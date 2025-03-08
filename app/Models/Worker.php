<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'status',
    ];

    public function isOnLeave()
    {
        return $this->status === 'В отпуске';
    }
}
