<?php

namespace App\Services\Bandle;

use App\Helpers\ResponsesHelper;
use App\Models\Bandle;
use App\Models\BlockType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Self_;

class BandleService
{
    protected int $id;
    protected int $user_id;

    protected string $title;
    protected string|null $description;

    protected int $hidden;

    public function __construct($id)
    {
        $this->id = $id;

        $bandle = Bandle::query()->find($id);
        $this->user_id = $bandle->user_id;
        $this->title = $bandle->title;
        $this->description = $bandle->description;
        $this->hidden = $bandle->hidden;
    }

    public static function create(int $user_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => ["required", 'string', 'max:100']
            , 'description' => ['nullable', 'string']
        ]);
        if ($validator->fails())
        {
            return ResponsesHelper::respondErrors($validator->errors()->messages());
        }
        $bandle = Bandle::query()->create(array_merge(['user_id' => $user_id], $validator->validated()));
        if($bandle)
        {
            return $bandle->id;
        }
        return 0;
    }

    public static function access($id):bool
    {
        if($bandle = Bandle::query()->find($id))
        {
            if($bandle->user_id == Auth::id())
            {
                return true;
            }
        }
        return false;
    }

    public function item_renew_modal()
    {
        $arr = $this->get();
        return view('bandle.modals.item_renew', $arr );
    }

    public function set_value_text(string $type,string $value) :bool
    {
        $this->$type = $value;
        return $this->save();
    }

    protected function save(): bool
    {
        $bandle = Bandle::query()->find($this->id);
        $bandle->title = $this->title;
        $bandle->description = $this->description;
        $bandle->hidden = $this->hidden;
        if ($bandle->save())
        {
            return true;
        }
        return false;
    }

    public function get(): array
    {
        return array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'access' => (Auth::check() && self::access($this->id))
        );
    }

    public function items_load():View
    {
        $arr = array(
            'id' => $this->id,
            'access' => (Auth::check() && self::access($this->id)),
            'items' => $this->get_items(),
        );
        return view('bandle.items', $arr);
    }

    public function get_items():array
    {
        $arr = array();
        $items = Bandle::query()->find($this->id)->blocks()->get();
        foreach ($items as $item)
        {
            $arr[] = array(
                'id' => $item->id,
                'sort' => $item->sort,
            );
        }
        return $arr;
    }

    public function item_add_modal():View
    {
        $arr = array(
            'id' => $this->id,
            'items' => $this->get_block_types()
        );
        return view('bandle.block.modals.item_add', $arr);
    }

    protected function get_block_types():array
    {
        $types = array();
        $block_types = BlockType::query()->orderBy('sort', 'asc')->get();
        foreach($block_types as $item)
        {
            $limit = $item->limit;
            $count = Bandle::query()->find($this->id)->blocks_count($item->id);
            if($count < $limit || $limit == 0) {
                $types[] = $item->toArray();
            }
        }
        return $types;
    }
}
