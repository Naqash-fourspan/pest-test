<?php

namespace App\Services;


use App\Models\Project;
use Arr;

class ProjectService
{

    public function recordActivity(Project $project, $description): void
    {

        $project->activity()->create([
            'user_id' => $project->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges($project, $description),

        ]);
    }

    protected function activityChanges(Project $project, $description)
    {
        if ($description == 'updated') {
            return [
                'before' => Arr::except(array_diff($project->old, $project->getAttributes()), 'updated_at'),
                'after' => Arr::except($project->getChanges(), 'updated_at')
            ];
        }
    }
}

