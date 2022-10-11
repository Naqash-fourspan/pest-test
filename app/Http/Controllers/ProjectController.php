<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function store(ProjectStoreRequest $request)
    {
        $project = auth()->user()->projects()->create([
            'uuid' => $request->uuid,
            'title' => $request->title,
            'description' => $request->description,
            'notes' => $request->notes
        ]);

        return redirect($project->path());
    }

    public function show(Request $request)
    {
        $project = Project::findOrFail($request->id);
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function update(Request $request)
    {
        $project = Project::findOrFail($request->route('project_id'));

        $this->authorize('update', $project);
        $project->update([
            'notes' => $request->notes
        ]);

        return redirect($project->path());
    }
}
