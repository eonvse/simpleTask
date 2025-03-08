<?php

namespace App\Models;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory, HasRoles;

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
