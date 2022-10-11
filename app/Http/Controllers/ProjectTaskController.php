<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
class ProjectTaskController extends Controller
{

    public function store(AddTaskRequest $request)
    {
        $project = Project::findOrFail($request->project_id);
        $this->authorize('update', $project);

        $project->addTask($request->body);

        return redirect($project->path());
    }

    public function update(Request $request)
    {
        $project = Project::findOrFail($request->route('project_id'));

        $this->authorize('update', $project);

        request()->validate(['body' => 'required']);
        $task = Task::findOrFail($request->route('task_id'));
        $task->update([
            'body' => $request->body,
            'completed' => $request->completed
        ]);

        return redirect($project->path());
    }

}
