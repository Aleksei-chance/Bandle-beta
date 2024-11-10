<?php

namespace App\Logic\Bandle;

use App\Models\Bandle;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\NameBlock;
use Illuminate\Support\Facades\Auth;

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

    public static function item_add($id, $block_type_id)
    {
        $user_id = Auth::id();
        $limit = BlockType::query()->find($block_type_id)->limit;
        $count = Bandle::query()->find($id)->blocks_count($block_type_id);
        $max = Bandle::query()->find($id)->blocks()->max('sort');
        $max++;
        if(($count < $limit || $limit == 0) && $block = Block::create([
            'bandle_id' => $id
            , 'user_id' => $user_id
            , 'block_type_id' => $block_type_id
            , 'sort' => $max
        ])) {
            if($block_type_id == 1 && NameBlock::query()->create([
                'block_id' => $block->id
                , 'user_id' => $user_id
            ])) {
                return 1;
            } else if($block_type_id == 2 || $block_type_id == 3) {
                return 1;
            }
            
        }
        return 0;
    }
}