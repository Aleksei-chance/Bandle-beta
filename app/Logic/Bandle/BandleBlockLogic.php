<?php

namespace App\Logic\Bandle;

use App\Models\Bandle;
use App\Models\BlockType;

class BandleBlockLogic
{
    public static function item_add_modal($bandle_id)
    {
        $items = array();
        $block_types = BlockType::query()->orderBy('sort', 'asc')->get();
        foreach($block_types as $item)
        {
            $limit = $item->limit;
            $count = Bandle::query()->find($bandle_id)->blocks_count($item->id);
            if($count < $limit || $limit == 0) {
                $items[] = $item->toArray();
            }
        }
        $arr = array(
            'id' => $bandle_id
            , 'items' => $items
        );
        return view('bandle.block.modals.item_add', $arr);
    } 
}