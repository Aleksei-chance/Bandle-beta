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

    public function __construct($id)
    {
        $this->id = $id;

        $block = Block::query()->find($id);
        $this->bandle_id = $block->bandle_id;
        $this->block_type_id = $block->block_type_id;
    }

    public static function access($id)
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
        return false;
    }

    public static function create(int $bandle_id, int $block_type_id):int
    {
        $bandle = Bandle::query()->find($bandle_id);
        $count = $bandle->blocks_count($block_type_id);
        $limit = BlockType::query()->find($block_type_id)->limit;
        if($count < $limit || $limit == 0)
        {
            $user_id = $bandle->user_id;
            $max = $bandle->blocks()->max('sort');
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
}
