<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
class ProjectTaskController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(AddTaskRequest $request)
    {
        $project = Project::where('uuid', $request->route('project_id'))->first();
        $this->authorize('update', $project);

        $project->tasks()->create([
            'uuid' => $request->uuid,
            'body' => $request->body,
        ]);

        return redirect($project->path());
    }


    public function update(UpdateTaskRequest $request)
    {
        $project = Project::where('uuid', $request->route('project_id'))->first();

        $this->authorize('update', $project);

        $task = Task::where('uuid', $request->route('task_id'))->first();
        $task->update([
            'body' => $request->body,
        ]);

        if ($request->has('completed') && $request->completed) {
            (new TaskService())->completeTask($task);
        } else {
            (new TaskService())->incompleteTask($task);
        }

        return redirect($project->path());
    }

}
