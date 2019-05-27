<?php

namespace App\Models;

use App\Models\Model;

class User extends Model
{
    protected $fields = [
        'name',
        'email',
        'password',
        'admin',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password'
    ];
}