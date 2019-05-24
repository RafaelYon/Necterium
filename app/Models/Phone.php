<?php

namespace App\Models;

use App\Models\Model;

class Phone extends Model
{
    protected $fields = [
        'number',
        'user_id',
        'created_at',
        'updated_at'
    ];
}