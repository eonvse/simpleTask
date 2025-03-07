<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable= [
        'name',
        'description',
        'status',
    ];

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class);
    }
}
