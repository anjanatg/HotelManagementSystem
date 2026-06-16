<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserManagement extends Model
{
    use HasFactory;

    protected $table = 'user_management';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'status',
    ];
}
