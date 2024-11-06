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
        $arr = array();
        $bandle = Bandle::query()->find($id);
    
        if($bandle) 
        {
            return view('user.bandle.modals.item_renew', array_merge($bandle->toArray(), $arr) );
        }
        
        return 0;
    }
}