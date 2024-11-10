<?php

namespace App\Logic\Bandle;

use App\Models\Bandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BandleLogic
{
    public static function item_add_modal() 
    {
        return view('user.bandle.modals.add_item');
    }

    public static function item_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => ["required", 'string', 'max:100']
            , 'description' => ['nullable', 'string']
        ]);

        if ($validator->fails()) 
        {
            $messages = $validator->errors()->messages();
            $errors = array();
            foreach($messages as $key => $massage) 
            {
                foreach($massage as $Item) 
                {
                    $errors[] = $key.":".$Item;
                }
            }
            return implode("|", $errors);
        }
    
        $data = $validator->validated();
        $data['user_id'] = Auth::id();
        if($bandle = Bandle::create($data)) {
            return $bandle->id;
        }
        return 0;
    }

    public static function access($id)
    {
        $bandle = Bandle::query()->find($id);
        
        $user_id = Auth::id();
        if($user_id == $bandle->user_id) 
        {
            return true;
        }
        return false;
    }

    public static function item_renew_modal($id)
    {
        $bandle = Bandle::query()->find($id);

        $arr = array(
            'id' => $id
            , 'title' => $bandle->title
            , 'description' => $bandle->description
        );
    
        if($bandle) 
        {
            return view('user.bandle.modals.item_renew', $arr );
        }
        
        return 0;
    }

    public static function set_value_text($id, $type, $value)
    {
        $bandle = Bandle::query()->find($id);
        $bandle->$type = $value;
        if($bandle->save())
        {
            return 1;
        }
        return 0;
    }

    public static function item_remove_modal($id)
    {
        $arr = array(
            'id' => $id
        );
        return view('user.bandle.modals.item_remove', $arr);
    }
}