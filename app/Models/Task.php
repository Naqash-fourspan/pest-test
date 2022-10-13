<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'body',
        'project_id',
        'completed',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = ['project'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    /*Functions*/

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function path()
    {
        return "/project/{$this->project->uuid}/tasks/{$this->uuid}";
    }
    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
