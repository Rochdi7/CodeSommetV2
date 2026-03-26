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

        return view('pages.admin.payments.index', compact('payments', 'projects'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();
        $selectedProject = $request->get('project_id');

        return view('pages.admin.payments.create', compact('projects', 'selectedProject'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'type' => 'required|string',
            'method' => 'required|string',
            'status' => 'required|string',
            'invoice_number' => 'nullable|string|max:100',
            'reference' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }

        Payment::create($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement ajouté avec succès.');
    }

    public function edit(Payment $payment)
    {
        $projects = Project::orderBy('name')->get();

        return view('pages.admin.payments.edit', compact('payment', 'projects'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'nullable|string|max:3',
            'type' => 'required|string',
            'method' => 'required|string',
            'status' => 'required|string',
            'invoice_number' => 'nullable|string|max:100',
            'reference' => 'nullable|string|max:255',
            'due_date' => 'nullable|date',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'paid' && empty($validated['paid_at'])) {
            $validated['paid_at'] = now();
        }

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Paiement mis à jour.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Paiement supprimé.');
    }

    public function byProject(Project $project)
    {
        $payments = $project->payments()->latest()->paginate(20);

        return view('pages.admin.payments.index', [
            'payments' => $payments,
            'projects' => Project::orderBy('name')->get(),
            'currentProject' => $project,
        ]);
    }
}
