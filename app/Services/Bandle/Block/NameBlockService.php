<?php

namespace App\Services\Bandle\Block;

use App\Models\Block;
use App\Models\NameBlock;
use Illuminate\View\View;

class NameBlockService extends BlockService
{
    protected string|null $name;
    protected string|null $pronouns;
    protected string|null $article;

    public function __construct($id)
    {
        parent::__construct($id);

        $content = Block::query()->find($id)->name_content();

        $this->name = $content->name;
        $this->pronouns = $content->pronouns;
        $this->article = $content->article;
    }

    public function load_content():View
    {
        $arr = array(
            'id' => $this->id,
            'name' => $this->name,
            'pronouns' => $this->pronouns,
            'article' => $this->article,
        );
        return view('bandle.block.name_block', $arr);
    }

    public static function add_content(int $block_id, int $user_id):int
    {
        $NameBlock = NameBlock::query()->create([
            'block_id' => $block_id
            , 'user_id' => $user_id
        ]);
        if($NameBlock)
        {
            return $NameBlock->id;
        }
        return 0;
    }

    public function item_renew_modal():View
    {
        $arr = array(
            'id' => $this->id,
            'name' => $this->name,
            'pronouns' => $this->pronouns,
            'article' => $this->article,
        );
        return view('bandle.block.modals.name_block_renew', $arr);
    }

    protected  function save():bool
    {
        $content = NameBlock::query()->where('block_id', '=', $this->id)->first();
        $content->name = $this->name;
        $content->pronouns = $this->pronouns;
        $content->article = $this->article;
        if($content->save())
        {
            return true;
        }
        return false;
    }
}
