<?php

namespace App\Actions\User;

use Illuminate\Http\Request;

class UserAction
{
    public function execute(Request $request)
    {
        $func = $request->func;
        
        if($func == 'create') {
            // return $user->registration($request);
        }
        else if ($func == 'auth') {
            // return $user->auth($request);
        }

        return '400 - Bad Request';
    }
}