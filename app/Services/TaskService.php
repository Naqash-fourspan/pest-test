<?php

namespace App\Services;


use App\Models\Task;

class TaskService
{
    public function completeTask(Task $task): void
    {
        $task->update(['completed' => true]);

        $task->project->recordActivity('completed_task');
    }

    public function incompleteTask(Task $task): void
    {
        $task->update(['completed' => false]);

        $task->project->recordActivity('incompleted_task');
    }
}
