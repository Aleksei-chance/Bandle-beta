<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bandle extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'publish', 'hidden'
    ];
}
