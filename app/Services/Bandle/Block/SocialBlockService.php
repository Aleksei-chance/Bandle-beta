<?php

namespace App\Services\Bandle\Block;

use App\Models\Block;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SocialBlockService extends BlockService
{
    public function load_content():View
    {
        $social_links = Block::query()->find($this->id)->social_links();
        $items = array();
        foreach ($social_links as $item)
        {
            $items[] = array(
                'id' => $item->id,
                'link' => $item->link,
                'icon' => $item->icon,
            );
        }
        $arr = array(
            'id' => $this->id,
            'icon' => $this->icon,
            'items' => $items,
            'access' => (Auth::check() && self::access($this->id)),
        );

        return view('bandle.block.social_block', $arr);
    }

    public function item_renew_modal():bool
    {

    }
}
