<?php

namespace App\Services\User;

use App\Helpers\ResponsesHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

abstract class UserService
{

    public function create(Request $request)
    {
        $validator = $this->validate($request->all(), ['unique:users,email'], ['confirmed']);
        if ($validator->fails())
        {
            return ResponsesHelper::respondErrors($validator->errors()->messages());
        }
        if($user = User::create($validator->validated())) {
            auth(guard: "web")->login($user);
            return 1;
        }
        return 0;
    }

    protected function validate($data, $email = [], $password = [])
    {
        return Validator::make($data, [
            'email' => array_merge(["required", "email", "string"], $email)
            , "password" => array_merge(["required"], $password)
        ]);
    }

    public function authorise(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails())
        {
            return ResponsesHelper::respondErrors($validator->errors()->messages(), '_login');
        }
        if(auth(guard: "web")->attempt($validator->validated())) {
            return 1;
        }
        return "email_login:|password_login:Wrong data";
    }
}