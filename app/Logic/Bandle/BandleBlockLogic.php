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

    public static function items_load($id)
    {
        $arr = array(
            'id' => $id
            , 'auth' => (Auth::check() && BandleLogic::access($id))
            , 'items' => Bandle::query()->find($id)->blocks()->get()->toArray()
        );

        return view('bandle.block.items', $arr);
    }

    public static function access($id) {
        $block = Block::query()->find($id);
        
        $user_id = Auth::id();
        if($user_id == $block->user_id) {
            return true;
        }
        return false;
    }

    public static function item_content_load($id)
    {
        $block = Block::query()->find($id);
        $bandle_id = $block->bandle_id;
        $BandleLogic = New BandleLogic;
        $BandleLogic = New BandleLogic($bandle_id, null);
        $auth = (Auth::check() && BandleLogic::access($bandle_id));

        $block_type_id = $block->block_type_id;
        $icon = BlockType::query()->find($block_type_id)->icon;
        $arr = array();
        if($block_type_id == 1) 
        {
            $arr['auth'] = $auth;
            $content = $block->name_content()->toArray();
            return view('bandle.block.name_block', array_merge($arr, $content));
        }
        else if($block_type_id == 2) 
        {
            $arr = array(
                'id' => $id
                , 'icon' => $icon
                , 'items' => $block->social_links()->get()->toArray()
                , 'auth' => $auth
            );

            return view('bandle.block.social_block', $arr);
        }
    }
}