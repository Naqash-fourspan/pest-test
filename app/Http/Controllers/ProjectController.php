<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
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
        $project = Project::where('uuid', '=', $request->id)->first();
        $this->authorize('update', $project);

        return view('projects.show', ['project' => ProjectResource::make($project)]);
    }

    public function update(UpdateProjectRequest $request)
    {
        $project = Project::where('uuid', $request->route('project_id'))->first();

        $project->update([
            'notes' => $request->notes
        ]);

        return redirect($project->path());
    }
}
