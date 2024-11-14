<?php

namespace App\Services\Collection;

use App\Helpers\ResponsesHelper;
use App\Models\Bandle;
use App\Models\User;
use App\Services\Bandle\BandleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory;
use Illuminate\View\View;

abstract class CollectionService
{
    protected int $id;
    protected int $bandle_limit;

    public function __construct(int $id)
    {
        $this->id = $id;

        $user = User::query()->find($id);
        $this->bandle_limit = $user->bandle_limit;
    }

    public function page_load($type_id)
    {
        $arr = array(
            'id' => $this->id,
            'type_id' => $type_id,
            'items' => $this->get_items(),
            'bandle_limit' => $this->bandle_limit
        );

        return view('collection.created.items', $arr);
    }

    protected function get_items():array
    {
        $arr = array();
        $items = User::query()->find($this->id)->bandles()->get();
        foreach ($items as $item)
        {
            $arr[] = array(
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description
            );
        }
        return $arr;
    }

    public static function access($id):bool
    {
        if($id == Auth::id())
        {
            return true;
        }
        return false;
    }

    public function item_add_modal(): false|View
    {
        $bandle_count = User::query()->find($this->id)->bandles_count();
        if($bandle_count < $this->bandle_limit)
        {
            return view('collection.created.modals.add_item', ['id' => $this->id]);
        }
        return false;
    }

}
