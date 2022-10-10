<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;

class ProjectTaskController extends Controller
{
    public function store(AddTaskRequest $request)
    {
        $project = Project::findOrFail($request->project_id);
        if (auth()->user()->isNot($project->owner)) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $project->addTask($request->body);

        return redirect($project->path());
    }
}
