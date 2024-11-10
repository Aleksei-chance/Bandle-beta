<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'bandle_id', 'user_id', 'sort', 'block_type_id', 'publish', 'hidden'
    ];
}
