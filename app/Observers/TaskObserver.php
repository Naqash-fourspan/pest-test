<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\TaskService;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function created(Task $task)
    {
        (new TaskService())->recordActivity($task, 'created_task');
    }

    /**
     * Handle the Task "updated" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function deleted(Task $task)
    {
        (new TaskService())->recordActivity($task, 'deleted_task');
    }

    /**
     * Handle the Task "restored" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     *
     * @param \App\Models\Task $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
