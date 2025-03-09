<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'description',
        'status',
    ];

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'worker_task','task_id','worker_id');
    }

    public function getCreatedAttribute()
    {
        return date('d.m.Y H:i', strtotime($this->created_at));
    }
}
