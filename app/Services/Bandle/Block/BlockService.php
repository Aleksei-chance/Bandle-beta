<?php

namespace App\Services\Bandle\Block;

use App\Models\Bandle;
use App\Models\Block;
use App\Models\BlockType;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BlockService
{
    protected int $id;

    protected int $bandle_id;
    protected int $block_type_id;

    protected string $icon;

    protected int $hidden;

    public function __construct($id)
    {
        $this->id = $id;

        $block = Block::query()->find($id);
        $this->bandle_id = $block->bandle_id;
        $this->block_type_id = $block->block_type_id;

        $this->icon = BlockType::query()->find($block->block_type_id)->icon;
    }

    public static function access($id):bool
    {
        if($block = Block::query()->find($id))
        {
            if($block->user_id == Auth::id())
            {
                return true;
            }
        }
        return false;
    }

    public function load_content():bool|View
    {
        $block_type_id = $this->block_type_id;
        if($block_type_id == 1)
        {
            return (new NameBlockService($this->id))->load_content();
        }
        else if($block_type_id == 2)
        {
            return (new SocialBlockService($this->id))->load_content();
        }
        else if($block_type_id == 3)
        {
            return (new ContactBlockService($this->id))->load_content();
        }
        return false;
    }

    public static function create(int $bandle_id, int $block_type_id)
    {
        $bandle = Bandle::query()->find($bandle_id);
        $count = $bandle->blocks_count($block_type_id);
        $limit = BlockType::query()->find($block_type_id)->limit;
        if($count < $limit || $limit == 0)
        {
            $user_id = $bandle->user_id;
            $max = $bandle->blocks()->max('sort');
            if($max == null)
            {
                $max = 0;
            }
            $block = Block::query()->create([
                'bandle_id' => $bandle_id
                , 'user_id' => $user_id
                , 'block_type_id' => $block_type_id
                , 'sort' => $max
            ]);
            if($block && (($block_type_id == 1 && NameBlockService::add_content($block->id, $user_id)) || $block_type_id == 2 || $block_type_id == 3))
            {
                return $block->id;
            }
        }
        return 0;
    }

    public function set_value_text($type, $value):bool
    {
        $this->$type = $value;
        return $this->save();
    }

    protected  function save():bool
    {
        $block = Block::query()->find($this->id);
        $block->hidden = $this->hidden;
        if($block->save())
        {
            return true;
        }
        return false;
    }

    public function item_renew_modal():bool|View
    {
        $block_type_id = $this->block_type_id;
        if($block_type_id == 1)
        {
            return (new NameBlockService($this->id))->item_renew_modal();
        }
        else if($block_type_id == 2)
        {
            return (new SocialBlockService($this->id))->item_renew_modal();
        }
        return false;
    }
}
