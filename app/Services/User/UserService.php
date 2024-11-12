<?php

namespace App\Services\User;

use App\Helpers\ResponsesHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class UserService
{

    public function create(Request $request)
    {
        $validator = $this->validate($request->all());
        if ($validator->fails())
        {
            return ResponsesHelper::respondErrors($validator->errors()->messages());
        }
        if($user = User::create($validator->validated())) {
            return $this->authorise($user);
        }
        return 0;
    }

    protected function validate($data)
    {
        return Validator::make($data, [
            'email' => ["required", "email", "string", "unique:users,email"]
            , "password" => ["required", "confirmed"]
        ]);
    }

    protected function authorise($data)
    {
        if(auth(guard: "web")->login($data))
        {
            return 1;
        }
        return 0;
    }
}