<?php

namespace App\Services;


use App\Models\Task;

class TaskService
{
    public function completeTask(Task $task): void
    {
        $task->update(['completed' => true]);

        $this->recordActivity($task, 'completed_task');
    }

    public function incompleteTask(Task $task): void
    {
        $task->update(['completed' => false]);

        $this->recordActivity($task, 'incompleted_task');
    }

    public function recordActivity(Task $task, $description): void
    {
        $task->activity()->create([
            'user_id' => $task->project->owner->id,
            'project_id' => $task->project_id,
            'description' => $description
        ]);
    }
}

