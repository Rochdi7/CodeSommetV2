<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use App\Services\InvoiceNumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    private const STATUSES = [
        'lead', 'proposal', 'negotiation', 'contracted',
        'discovery', 'design', 'development', 'testing',
        'review', 'launched', 'maintenance', 'completed', 'cancelled', 'on_hold',
    ];

    private const PRIORITIES = ['low', 'medium', 'high', 'urgent'];

    private const TYPES = [
        'website', 'ecommerce', 'webapp', 'saas', 'dashboard',
        'mobile_app', 'landing_page', 'redesign', 'maintenance', 'other',
    ];

    public function __construct(private InvoiceNumberGenerator $invoiceNumbers)
    {
    }
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('billing_type')) {
            $query->where('billing_type', $request->billing_type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'created_at');
        $dir  = $request->get('dir', 'desc');
        $projects = $query->orderBy($sort, $dir)->paginate(15);

        return view('backoffice.pages.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('backoffice.pages.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'nullable|email|max:255',
            'client_phone'     => 'nullable|string|max:50',
            'client_company'   => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'type'             => ['required', Rule::in(self::TYPES)],
            'type_custom'      => 'nullable|string|max:100',
            'billing_type'     => 'nullable|string|in:one_time,recurring',
            'recurring_period' => 'nullable|string|in:monthly,quarterly,annually',
            'tech_stack'       => 'nullable|string',
            'domain'           => 'nullable|string|max:255',
            'staging_url'      => 'nullable|url|max:255',
            'production_url'   => 'nullable|url|max:255',
            'repo_url'         => 'nullable|url|max:255',
            'status'           => ['required', Rule::in(self::STATUSES)],
            'priority'         => ['required', Rule::in(self::PRIORITIES)],
            'start_date'       => 'nullable|date',
            'deadline'         => 'nullable|date',
            'quoted_price'     => 'nullable|numeric|min:0',
            'agreed_price'     => 'nullable|numeric|min:0',
            'currency'         => 'nullable|string|max:3',
            'tva_percent'      => 'nullable|numeric|min:0|max:100',
            'notes'            => 'nullable|string',
        ]);

        if (! empty($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        }

        $validated['slug']          = Str::slug($validated['name']);
        $validated['quoted_price']  = $validated['quoted_price'] ?? 0;
        $validated['agreed_price']  = $validated['agreed_price'] ?? 0;
        $validated['tva_percent']   = $validated['tva_percent'] ?? 0;

        // Auto billing_type based on type
        if (empty($validated['billing_type'])) {
            $validated['billing_type'] = in_array($validated['type'], ['seo', 'maintenance'])
                ? 'recurring'
                : 'one_time';
        }
        if ($validated['billing_type'] === 'recurring' && empty($validated['recurring_period'])) {
            $validated['recurring_period'] = 'monthly';
        }

        if (empty($validated['phases'])) {
            $validated['phases'] = [
                ['name' => 'Découverte & Brief',       'status' => 'pending'],
                ['name' => 'Wireframes & UX',          'status' => 'pending'],
                ['name' => 'Design UI',                'status' => 'pending'],
                ['name' => 'Développement Frontend',   'status' => 'pending'],
                ['name' => 'Développement Backend',    'status' => 'pending'],
                ['name' => 'Intégration & API',        'status' => 'pending'],
                ['name' => 'Tests & QA',               'status' => 'pending'],
                ['name' => 'Revue Client',             'status' => 'pending'],
                ['name' => 'Lancement',                'status' => 'pending'],
            ];
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Projet créé avec succès.');
    }

    public function show(Project $project)
    {
        $project->load(['payments', 'expenses']);
        return view('backoffice.pages.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('backoffice.pages.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'nullable|email|max:255',
            'client_phone'     => 'nullable|string|max:50',
            'client_company'   => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'type'             => ['required', Rule::in(self::TYPES)],
            'type_custom'      => 'nullable|string|max:100',
            'billing_type'     => 'nullable|string|in:one_time,recurring',
            'recurring_period' => 'nullable|string|in:monthly,quarterly,annually',
            'tech_stack'       => 'nullable|string',
            'domain'           => 'nullable|string|max:255',
            'staging_url'      => 'nullable|url|max:255',
            'production_url'   => 'nullable|url|max:255',
            'repo_url'         => 'nullable|url|max:255',
            'status'           => ['required', Rule::in(self::STATUSES)],
            'priority'         => ['required', Rule::in(self::PRIORITIES)],
            'progress'         => 'nullable|integer|min:0|max:100',
            'start_date'       => 'nullable|date',
            'deadline'         => 'nullable|date',
            'launched_at'      => 'nullable|date',
            'completed_at'     => 'nullable|date',
            'quoted_price'     => 'nullable|numeric|min:0',
            'agreed_price'     => 'nullable|numeric|min:0',
            'currency'         => 'nullable|string|max:3',
            'tva_percent'      => 'nullable|numeric|min:0|max:100',
            'phases'           => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        if (! empty($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        }

        if (! empty($validated['phases'])) {
            $validated['phases'] = json_decode($validated['phases'], true);
        }

        $validated['quoted_price'] = $validated['quoted_price'] ?? 0;
        $validated['agreed_price'] = $validated['agreed_price'] ?? 0;
        $validated['tva_percent']  = $validated['tva_percent'] ?? 0;

        if (empty($validated['billing_type'])) {
            $validated['billing_type'] = 'one_time';
        }

        $project->update($validated);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Projet mis à jour.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Projet supprimé.');
    }

    public function updateStatus(Request $request, Project $project)
    {
        $request->validate(['status' => ['required', Rule::in(self::STATUSES)]]);
        $project->update(['status' => $request->status]);

        if ($request->status === 'launched') {
            $project->update(['launched_at' => now()]);
        }
        if ($request->status === 'completed') {
            $project->update(['completed_at' => now(), 'progress' => 100]);
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    public function updateProgress(Request $request, Project $project)
    {
        $request->validate(['progress' => 'required|integer|min:0|max:100']);
        $project->update(['progress' => $request->progress]);

        return back()->with('success', 'Progression mise à jour.');
    }

    /** Quick-add a payment from the project show page and redirect back. */
    public function addPayment(Request $request, Project $project)
    {
        $validated = $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:99999999.99',
            'type'           => 'required|string|max:30',
            'billing_period' => 'nullable|string|max:20',
            'payment_mode'   => 'required|in:full,partial',
            'partial_amount' => 'nullable|numeric|min:0|lte:amount',
            'method'         => 'required|string|max:30',
            'method_custom'  => 'nullable|string|max:100',
            'due_date'       => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;
        $validated['currency']   = $project->currency;

        if ($validated['payment_mode'] === 'full') {
            $validated['status']         = 'paid';
            $validated['paid_at']        = now()->toDateString();
            $validated['partial_amount'] = null;
        } else {
            $validated['status'] = 'partial';
        }

        // Reject amounts that would exceed the remaining balance (paid only).
        if ($validated['status'] === 'paid') {
            $alreadyPaid = (float) $project->payments()->where('status', 'paid')->sum('amount');
            if (($alreadyPaid + (float) $validated['amount']) > ((float) $project->agreed_price + 0.01)) {
                $remaining = max(0, (float) $project->agreed_price - $alreadyPaid);

                return back()->withErrors(['amount' => 'Le montant dépasse le solde restant ('
                    . number_format($remaining, 2) . ' ' . ($project->currency ?? 'MAD') . ').']);
            }
        }

        // Concurrency-safe, non-colliding invoice number.
        $this->createPaymentWithInvoice($validated);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Paiement ajouté.');
    }

    /** Update project phases status from the show page. */
    public function updatePhases(Request $request, Project $project)
    {
        $request->validate(['phases' => 'required|string|max:20000']);

        $phases = json_decode($request->phases, true);
        if (! is_array($phases)) {
            return back()->with('error', 'Données invalides.');
        }
        if (count($phases) > 100) {
            return back()->with('error', 'Trop de phases.');
        }

        // Normalize/whitelist each phase to a known shape.
        $allowedStatuses = ['pending', 'in_progress', 'completed'];
        $clean = [];
        foreach ($phases as $phase) {
            if (! is_array($phase)) {
                return back()->with('error', 'Données invalides.');
            }
            $clean[] = [
                'name'   => is_string($phase['name'] ?? null) ? Str::limit($phase['name'], 200, '') : '',
                'status' => in_array($phase['status'] ?? null, $allowedStatuses, true) ? $phase['status'] : 'pending',
            ];
        }

        $project->update(['phases' => $clean]);

        return back()->with('success', 'Phases mises à jour.');
    }

    /** Generate a 30/40/30 payment schedule for the project. */
    public function generatePaymentSchedule(Project $project)
    {
        $total = (float) $project->agreed_price;
        if ($total <= 0) {
            return back()->with('error', 'Le prix convenu doit être supérieur à 0 pour générer un planning.');
        }

        // First and second instalments are rounded; the final one is the
        // remainder, so the three always sum to the total exactly.
        $first  = round($total * 0.30, 2);
        $second = round($total * 0.40, 2);
        $third  = round($total - $first - $second, 2);

        $schedule = [
            ['type' => 'deposit',   'amount' => $first,  'label' => 'Acompte 30%'],
            ['type' => 'milestone', 'amount' => $second, 'label' => 'Jalon 40%'],
            ['type' => 'final',     'amount' => $third,  'label' => 'Solde final 30%'],
        ];

        DB::transaction(function () use ($project, $schedule) {
            // Remove existing pending payments, then rebuild — atomically.
            $project->payments()->where('status', 'pending')->delete();

            foreach ($schedule as $s) {
                $this->createPaymentWithInvoice([
                    'project_id' => $project->id,
                    'amount'     => $s['amount'],
                    'currency'   => $project->currency,
                    'type'       => $s['type'],
                    'method'     => 'bank_transfer',
                    'status'     => 'pending',
                    'notes'      => $s['label'],
                ]);
            }
        });

        return redirect()->route('admin.projects.show', $project)->with('success', 'Planning 30/40/30 généré.');
    }

    /**
     * Create a payment with a unique, non-colliding invoice number, retrying
     * on the rare unique-constraint conflict.
     */
    private function createPaymentWithInvoice(array $data): Payment
    {
        for ($attempt = 0; $attempt < 3; $attempt++) {
            try {
                $data['invoice_number'] = $data['invoice_number']
                    ?? $this->invoiceNumbers->next($data['billing_period'] ?? null);

                return Payment::create($data);
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                $data['invoice_number'] = null;
            }
        }

        throw new \RuntimeException('Could not allocate a unique invoice number.');
    }
}
