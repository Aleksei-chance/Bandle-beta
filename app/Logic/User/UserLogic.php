<?php

namespace App\Logic\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLogic {

    public function registration($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ["required", "email", "string", "unique:users,email"]
            , "password" => ["required", "confirmed"]
        ]);

        
        if ($validator->fails()) 
        {
            $messages = $validator->errors()->messages();
            $errors = array();
            foreach($messages as $key => $massage) {
                foreach($massage as $Item) {
                    $errors[] = $key.":".$Item;
                }
            }

            return implode("|", $errors);
        }

        $data = $validator->validated();

        if($user = User::create($data)) {
            auth( guard: "web")->login($user);
            return 1;
        }

        return 0;
    }

    public function auth($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ["required", "email", "string"]
            , "password" => ["required"]
        ]);

        if ($validator->fails()) 
        {
            $messages = $validator->errors()->messages();
            $errors = array();
            foreach($messages as $key => $massage) {
                foreach($massage as $Item) {
                    $errors[] = $key."_login:".$Item;
                }
            }

            return implode("|", $errors);
        }

        $data = $validator->validated();

        if(Auth::attempt($data)) {
            return 1;
        }
        return "email_login:|password_login:Wrong data";
    }
}