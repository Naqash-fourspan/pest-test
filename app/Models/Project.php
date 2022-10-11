<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'owner_id',
        'notes',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
    public function path()
    {
        return "/project/{$this->id}";
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}
