<?php

namespace App\Logic\Bandle;

use App\Models\Bandle;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\ContactType;
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
        else if ($block_type_id == 3) 
        {
            $contacts = $block->contacts()->get();
            $items = array();
            foreach($contacts as $item) 
            {
                $icon = ContactType::query()->find($item->contact_type_id)->icon;
                $items[] = array(
                    'id' => $item->id
                    , 'icon' => $icon
                    , 'type' => $item->contact_type_id
                    , 'value' => $item->value
                );
            }

            $arr = array(
                'id' => $id
                , 'icon' => $icon
                , 'items' => $items
                , 'auth' => $auth
            );

            return view('bandle.block.contact_block', $arr);
        }
        return 0;
    }

    public static function item_remove_modal($id)
    {
        $arr = array(
            'id' => $id
            , 'bandle_id' => Block::query()->find($id)->bandle_id
        );
        return view('bandle.block.modals.item_remove', $arr);
    }

    public static function item_remove($id)
    {
        $user_id = Auth::id();
        $block = Block::query()->find($id);
        $block->hidden = 1;
        $sort = $block->sort;
        $bandle_id = $block->bandle_id;
        if($block->save()) {

            $blocks = Block::query()->select('id')->where('sort', '>', $sort)->where('bandle_id', $bandle_id)
            ->where('user_id', $user_id)->where('publish', 1)->where('hidden', 0)->get()->toArray();

            foreach($blocks as $item) {
                $block = Block::query()->find($item['id']);
                $sort = $block->sort;
                $block->sort = $sort - 1;
                $block->save();
            }

            $block_type_id = Block::query()->find($id)->block_type_id;
            if($block_type_id == 1) {
                $name_block_id = Block::query()->find($id)->name_content()->id;
                $name_block = NameBlock::query()->find($name_block_id);
                $name_block->hidden = 1;
                if($name_block->save()) {
                    return 1;
                }
            } else if($block_type_id == 2 || $block_type_id == 3) {
                return 1;
            }
        }
        return 0;
    }

    public static function item_renew_modal($id)
    {
        $block_type_id = Block::query()->find($id)->block_type_id;
        $block_type = BlockType::query()->find($block_type_id);
        if($block_type_id == 1) {
            $content = Block::query()->find($id)->name_content()->toArray();
            $content['block_id'] = $id;
            return view('bandle.block.modals.name_block_renew', $content);
        } else if ($block_type_id == 2) {
            $content = array(
                'block_id' => $id
                , 'icon' => $block_type->icon
                , 'name' => $block_type->name
                , 'items' => Block::query()->find($id)->social_links()->get()->toArray()
            );
            return view('user.bandle.block.modal.social_block_renew', $content);
        } else if($block_type_id == 3) {
            
            $contact_types = ContactType::get();
            $contact_items = array();
            foreach($contact_types as $item) {
                $contact_items[$item->id] = array(
                    'id' => $item->id
                    , 'icon' => $item->icon
                    , 'name' => $item->name
                );
            }
            
            $content = array(
                'block_id' => $id
                , 'icon' => $block_type->icon
                , 'name' => $block_type->name
                , 'contact_types' => json_encode($contact_items)
                , 'items' => Block::query()->find($id)->contacts()->get()->toArray()
            );
            return view('user.bandle.block.modal.contact_block_renew', $content);
        }
        return 0;
    }

    public static function set_value_text($id, $type, $value, $block_type_id){
        if($block_type_id == 1)
        {
            return BandleNameBlockLogic::set_value_text($id, $type, $value);
        }

        return 0;
    }
}

class BandleNameBlockLogic
{
    public static function set_value_text($id, $type, $value)
    {
        
    }
}