<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
        $validated = $request->validate([
            'project_id'     => 'required|exists:projects,id',
            'amount'         => 'required|numeric|min:0.01',
            'currency'       => 'nullable|string|max:3',
            'type'           => 'nullable|string',
            'billing_period' => 'nullable|string|max:20',
            'payment_mode'   => 'required|in:full,partial',
            'partial_amount' => 'nullable|numeric|min:0',
            'method'         => 'required|string',
            'method_custom'  => 'nullable|string|max:100',
            'status'         => 'nullable|string',
            'invoice_number' => 'nullable|string|max:100',
            'reference'      => 'nullable|string|max:255',
            'due_date'       => 'nullable|date',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        // Auto-derive status from payment_mode
        if ($validated['payment_mode'] === 'full') {
            $validated['status']         = 'paid';
            $validated['paid_at']        = $validated['paid_at'] ?? now()->toDateString();
            $validated['partial_amount'] = null;
        } else {
            // partial
            $validated['status'] = 'partial';
            if (isset($validated['partial_amount']) && $validated['partial_amount'] >= $validated['amount']) {
                $validated['status']  = 'paid'; // fully covered despite being marked partial
                $validated['paid_at'] = $validated['paid_at'] ?? now()->toDateString();
            }
        }

        // Auto-generate invoice number if empty
        if (empty($validated['invoice_number'])) {
            $count = Payment::whereYear('created_at', now()->year)->count() + 1;
            $validated['invoice_number'] = $this->buildInvoiceNumber($validated['billing_period'] ?? null, $count);
        }

        Payment::create($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement ajouté avec succès.');
    }

    public function edit(Payment $payment)
    {
        $projects = Project::orderBy('name')->get();

        return view('backoffice.pages.payments.edit', compact('payment', 'projects'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'project_id'     => 'required|exists:projects,id',
            'amount'         => 'required|numeric|min:0.01',
            'currency'       => 'nullable|string|max:3',
            'type'           => 'nullable|string',
            'billing_period' => 'nullable|string|max:20',
            'payment_mode'   => 'required|in:full,partial',
            'partial_amount' => 'nullable|numeric|min:0',
            'method'         => 'required|string',
            'method_custom'  => 'nullable|string|max:100',
            'status'         => 'nullable|string',
            'invoice_number' => 'nullable|string|max:100',
            'reference'      => 'nullable|string|max:255',
            'due_date'       => 'nullable|date',
            'paid_at'        => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

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

        // Re-generate invoice number if period changed and no custom invoice
        if (empty($payment->invoice_number) || empty($validated['invoice_number'])) {
            $count = Payment::whereYear('created_at', now()->year)->count() + 1;
            $validated['invoice_number'] = $this->buildInvoiceNumber($validated['billing_period'] ?? null, $count);
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
     * Build a structured invoice number.
     * - Recurring monthly  "2026-03" → INV-2026-MAR-001
     * - Recurring quarterly "2026-Q2" → INV-2026-Q2-001
     * - Recurring annually "2026"    → INV-2026-AN-001
     * - One-time                     → INV-2026-001
     */
    private function buildInvoiceNumber(?string $billingPeriod, int $seq): string
    {
        $seq = str_pad($seq, 3, '0', STR_PAD_LEFT);

        if ($billingPeriod) {
            if (preg_match('/^(\d{4})-(\d{2})$/', $billingPeriod, $m)) {
                $months = ['','JAN','FEV','MAR','AVR','MAI','JUN','JUL','AOU','SEP','OCT','NOV','DEC'];
                $tag = $m[1].'-'.($months[(int)$m[2]] ?? $m[2]);
            } elseif (preg_match('/^(\d{4})-(Q\d)$/', $billingPeriod, $m)) {
                $tag = $m[1].'-'.$m[2];
            } else {
                $tag = $billingPeriod.'-AN';
            }
            return 'INV-'.$tag.'-'.$seq;
        }

        return 'INV-'.now()->year.'-'.$seq;
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
