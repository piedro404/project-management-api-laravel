<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'concluded_at',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'concluded_at',
    ];

    // User
    
    public function user()
    {
        return $this->project->user;
    }

    // Project

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Repositories
    public function scopeSearchStatus($query, int $status)
    {
        return $query->where('status', $status)->orderBy('end_date','asc');
    }

    // Boots
    public static function boot()
    {
        parent::boot();

        static::saving(function ($task) {
            if ($task->isDirty('status') && $task->status == 2) {
                $task->concluded_at = now();
            } else {
                $task->concluded_at = null;
            }
        });
    }
}
