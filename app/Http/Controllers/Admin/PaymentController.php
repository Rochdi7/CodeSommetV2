<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use App\Services\InvoiceNumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /** Allowed enum-like values (payments columns are plain strings in the DB). */
    private const STATUSES = ['pending', 'partial', 'paid', 'overdue', 'cancelled', 'refunded'];

    private const TYPES = ['deposit', 'milestone', 'final', 'recurring', 'one_time', 'other'];

    private const METHODS = ['bank_transfer', 'cash', 'card', 'paypal', 'wise', 'stripe', 'check', 'other'];

    public function __construct(private InvoiceNumberGenerator $invoiceNumbers)
    {
    }

    /** Validation rules shared by store() and update(). */
    private function rules(): array
    {
        return [
            'project_id'     => 'required|exists:projects,id',
            'amount'         => 'required|numeric|min:0.01|max:99999999.99',
            'currency'       => 'nullable|string|max:3',
            'type'           => ['nullable', Rule::in(self::TYPES)],
            'billing_period' => 'nullable|string|max:20',
            'payment_mode'   => 'required|in:full,partial',
            'partial_amount' => 'nullable|numeric|min:0|lte:amount',
            'method'         => ['required', Rule::in(self::METHODS)],
            'method_custom'  => 'nullable|string|max:100',
            'status'         => ['nullable', Rule::in(self::STATUSES)],
            'invoice_number' => 'nullable|string|max:100',
            'reference'      => 'nullable|string|max:255',
            'due_date'       => 'nullable|date',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string',
        ];
    }
    public function index(Request $request)
    {
        $query = Payment::with('project');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $payments = $query->latest()->paginate(20);
        $projects = Project::orderBy('name')->get();

        return view('backoffice.pages.payments.index', compact('payments', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $selectedProject = $request->get('project_id');

        return view('backoffice.pages.payments.create', compact('projects', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->applyPaymentMode($validated);

        // Reject payments that would exceed the project's remaining balance.
        if ($error = $this->overpaymentError($validated, null)) {
            return back()->withInput()->withErrors(['amount' => $error]);
        }

        $this->createWithInvoiceNumber($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement ajouté avec succès.');
    }

    public function edit(Payment $payment)
    {
        $projects = Project::orderBy('name')->get();

        return view('backoffice.pages.payments.edit', compact('payment', 'projects'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate($this->rules());

        $this->applyPaymentMode($validated);

        if ($error = $this->overpaymentError($validated, $payment->id)) {
            return back()->withInput()->withErrors(['amount' => $error]);
        }

        // Preserve an already-issued invoice number. Only generate a new one
        // when the payment does not yet have one AND the form did not supply one.
        if (! empty($payment->invoice_number)) {
            // Keep the existing number; ignore a blank form field.
            unset($validated['invoice_number']);
        } elseif (empty($validated['invoice_number'])) {
            $validated['invoice_number'] = $this->generateUniqueInvoiceNumber($validated['billing_period'] ?? null);
        }

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement mis à jour.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Paiement supprimé.');
    }

    /**
     * Derive status/paid_at from the payment mode.
     */
    private function applyPaymentMode(array &$validated): void
    {
        if ($validated['payment_mode'] === 'full') {
            $validated['status']         = 'paid';
            $validated['paid_at']        = $validated['paid_at'] ?? now()->toDateString();
            $validated['partial_amount'] = null;
        } else {
            $validated['status'] = 'partial';
            if (isset($validated['partial_amount']) && $validated['partial_amount'] >= $validated['amount']) {
                $validated['status']  = 'paid';
                $validated['paid_at'] = $validated['paid_at'] ?? now()->toDateString();
            }
        }
    }

    /**
     * Return an error message if this payment would push the project's total
     * paid past its agreed price, else null. Only "paid" payments count toward
     * the balance. $ignoreId excludes the current payment on update.
     */
    private function overpaymentError(array $validated, ?int $ignoreId): ?string
    {
        // Only enforce for payments that will count as paid.
        if (($validated['status'] ?? null) !== 'paid') {
            return null;
        }

        $project = Project::find($validated['project_id']);
        if (! $project || $project->agreed_price === null) {
            return null;
        }

        $alreadyPaid = (float) $project->payments()
            ->where('status', 'paid')
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->sum('amount');

        $newTotal = $alreadyPaid + (float) $validated['amount'];

        // Allow a 1-cent rounding tolerance.
        if ($newTotal > ((float) $project->agreed_price + 0.01)) {
            $remaining = max(0, (float) $project->agreed_price - $alreadyPaid);

            return 'Le montant dépasse le solde restant du projet ('
                . number_format($remaining, 2) . ' ' . ($project->currency ?? 'MAD') . ').';
        }

        return null;
    }

    /**
     * Create a payment, generating a unique invoice number if none supplied,
     * inside a transaction and retrying on the rare unique-constraint conflict.
     */
    private function createWithInvoiceNumber(array $validated): Payment
    {
        for ($attempt = 0; $attempt < 3; $attempt++) {
            try {
                return DB::transaction(function () use ($validated) {
                    if (empty($validated['invoice_number'])) {
                        $validated['invoice_number'] = $this->invoiceNumbers
                            ->next($validated['billing_period'] ?? null);
                    }

                    return Payment::create($validated);
                });
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                // Another request took the number; retry with a fresh sequence.
                $validated['invoice_number'] = null;
            }
        }

        throw new \RuntimeException('Could not allocate a unique invoice number.');
    }

    /**
     * Generate a unique invoice number (used on update when regenerating).
     */
    private function generateUniqueInvoiceNumber(?string $billingPeriod): string
    {
        return DB::transaction(fn () => $this->invoiceNumbers->next($billingPeriod));
    }

    public function byProject(Project $project)
    {
        $payments = $project->payments()->latest()->paginate(20);

        return view('backoffice.pages.payments.index', [
            'payments'       => $payments,
            'projects'       => Project::orderBy('name')->get(),
            'currentProject' => $project,
        ]);
    }
}
