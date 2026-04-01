<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
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

        return view('pages.admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.admin.projects.create');
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
            'type'             => 'required|string',
            'type_custom'      => 'nullable|string|max:100',
            'billing_type'     => 'nullable|string|in:one_time,recurring',
            'recurring_period' => 'nullable|string|in:monthly,quarterly,annually',
            'tech_stack'       => 'nullable|string',
            'domain'           => 'nullable|string|max:255',
            'staging_url'      => 'nullable|url|max:255',
            'production_url'   => 'nullable|url|max:255',
            'repo_url'         => 'nullable|url|max:255',
            'status'           => 'required|string',
            'priority'         => 'required|string',
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
        return view('pages.admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('pages.admin.projects.edit', compact('project'));
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
            'type'             => 'required|string',
            'type_custom'      => 'nullable|string|max:100',
            'billing_type'     => 'nullable|string|in:one_time,recurring',
            'recurring_period' => 'nullable|string|in:monthly,quarterly,annually',
            'tech_stack'       => 'nullable|string',
            'domain'           => 'nullable|string|max:255',
            'staging_url'      => 'nullable|url|max:255',
            'production_url'   => 'nullable|url|max:255',
            'repo_url'         => 'nullable|url|max:255',
            'status'           => 'required|string',
            'priority'         => 'required|string',
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
        $request->validate(['status' => 'required|string']);
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
            'amount'         => 'required|numeric|min:0.01',
            'type'           => 'required|string',
            'billing_period' => 'nullable|string|max:20',
            'payment_mode'   => 'required|in:full,partial',
            'partial_amount' => 'nullable|numeric|min:0',
            'method'         => 'required|string',
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

        // Auto invoice number (period-aware)
        $count  = Payment::whereYear('created_at', now()->year)->count() + 1;
        $period = $validated['billing_period'] ?? null;
        $seq    = str_pad($count, 3, '0', STR_PAD_LEFT);

        if ($period) {
            if (preg_match('/^(\d{4})-(\d{2})$/', $period, $m)) {
                $months = ['','JAN','FEV','MAR','AVR','MAI','JUN','JUL','AOU','SEP','OCT','NOV','DEC'];
                $tag = $m[1].'-'.($months[(int)$m[2]] ?? $m[2]);
            } elseif (preg_match('/^(\d{4})-(Q\d)$/', $period, $m)) {
                $tag = $m[1].'-'.$m[2];
            } else {
                $tag = $period.'-AN';
            }
            $validated['invoice_number'] = 'INV-'.$tag.'-'.$seq;
        } else {
            $validated['invoice_number'] = 'INV-'.now()->year.'-'.$seq;
        }

        Payment::create($validated);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Paiement ajouté.');
    }

    /** Update project phases status from the show page. */
    public function updatePhases(Request $request, Project $project)
    {
        $request->validate(['phases' => 'required|string']);
        $phases = json_decode($request->phases, true);
        if (! is_array($phases)) {
            return back()->with('error', 'Données invalides.');
        }
        $project->update(['phases' => $phases]);
        return back()->with('success', 'Phases mises à jour.');
    }

    /** Generate a 30/40/30 payment schedule for the project. */
    public function generatePaymentSchedule(Project $project)
    {
        // Remove existing pending payments first
        $project->payments()->where('status', 'pending')->delete();

        $total = (float) $project->agreed_price;
        $year  = now()->year;

        $schedule = [
            ['type' => 'deposit',   'pct' => 30, 'label' => 'Acompte 30%'],
            ['type' => 'milestone', 'pct' => 40, 'label' => 'Jalon 40%'],
            ['type' => 'final',     'pct' => 30, 'label' => 'Solde final 30%'],
        ];

        $count = Payment::whereYear('created_at', now()->year)->count();

        foreach ($schedule as $i => $s) {
            $count++;
            Payment::create([
                'project_id'     => $project->id,
                'amount'         => round($total * $s['pct'] / 100, 2),
                'currency'       => $project->currency,
                'type'           => $s['type'],
                'method'         => 'bank_transfer',
                'status'         => 'pending',
                'invoice_number' => 'INV-' . $year . '-' . str_pad($count, 3, '0', STR_PAD_LEFT),
                'notes'          => $s['label'],
            ]);
        }

        return redirect()->route('admin.projects.show', $project)->with('success', 'Planning 30/40/30 généré.');
    }
}
