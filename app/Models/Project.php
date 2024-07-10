<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    // User
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tasks

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
