<?php

namespace App\Logic\Bandle;

use App\Models\Bandle;
use App\Models\BlockType;

class BandleBlockLogic
{
    public static function item_add_modal($bandle_id)
    {
        $arr = array();
    
        return view('bandle.block.modals.item_add', $arr);
    } 
}