<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'created_at');
        $dir = $request->get('dir', 'desc');
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
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_company' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'tech_stack' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
            'staging_url' => 'nullable|url|max:255',
            'production_url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'status' => 'required|string',
            'priority' => 'required|string',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'quoted_price' => 'nullable|numeric|min:0',
            'agreed_price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'notes' => 'nullable|string',
        ]);

        // Convert tech_stack from comma-separated to array
        if (! empty($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        }

        $validated['slug'] = Str::slug($validated['name']);

        // Default phases for web dev projects
        if (empty($validated['phases'])) {
            $validated['phases'] = [
                ['name' => 'Découverte & Brief', 'status' => 'pending'],
                ['name' => 'Wireframes & UX', 'status' => 'pending'],
                ['name' => 'Design UI', 'status' => 'pending'],
                ['name' => 'Développement Frontend', 'status' => 'pending'],
                ['name' => 'Développement Backend', 'status' => 'pending'],
                ['name' => 'Intégration & API', 'status' => 'pending'],
                ['name' => 'Tests & QA', 'status' => 'pending'],
                ['name' => 'Revue Client', 'status' => 'pending'],
                ['name' => 'Lancement', 'status' => 'pending'],
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
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:50',
            'client_company' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'tech_stack' => 'nullable|string',
            'domain' => 'nullable|string|max:255',
            'staging_url' => 'nullable|url|max:255',
            'production_url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'status' => 'required|string',
            'priority' => 'required|string',
            'progress' => 'nullable|integer|min:0|max:100',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'launched_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'quoted_price' => 'nullable|numeric|min:0',
            'agreed_price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'phases' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (! empty($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        }

        if (! empty($validated['phases'])) {
            $validated['phases'] = json_decode($validated['phases'], true);
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
}
