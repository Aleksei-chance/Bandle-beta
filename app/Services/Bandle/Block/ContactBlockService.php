<?php

namespace App\Services\Bandle\Block;

use App\Models\Block;
use App\Models\ContactType;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactBlockService extends BlockService
{
    public function load_content():View
    {
        $contacts = Block::query()->find($this->id)->contacts()->get();
        $items = array();
        foreach($contacts as $item)
        {
            $icon = ContactType::query()->find($item->contact_type_id)->icon;
            $items[] = array(
                'id' => $item->id,
                'icon' => $icon,
                'type' => $item->contact_type_id,
                'value' => $item->value,
            );
        }

        $arr = array(
            'id' => $this->id,
            'icon' => $this->icon,
            'items' => $items,
            'access' => (Auth::check() && self::access($this->id)),
        );

        return view('bandle.block.contact_block', $arr);
    }
}
