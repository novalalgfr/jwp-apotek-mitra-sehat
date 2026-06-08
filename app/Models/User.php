<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}