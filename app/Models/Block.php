<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'bandle_id', 'user_id', 'sort', 'block_type_id', 'publish', 'hidden'
    ];

    public function name_content() {
        return $this->hasOne(NameBlock::class, 'block_id')->where('publish', '1')->where('hidden', '0')->first();
    }

    
}
