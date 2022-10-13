<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\ProjectService;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function created(Project $project)
    {
        (new ProjectService())->recordActivity($project, 'created');
    }

    /**
     * Handle the Project "updating" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */

    public function updating(Project $project): void
    {
        $project->old = $project->getOriginal();
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function updated(Project $project): void
    {
        (new ProjectService())->recordActivity($project, 'updated');
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param \App\Models\Project $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }

}
