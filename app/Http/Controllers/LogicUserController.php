<?php

namespace App\Http\Controllers;

use App\Logic\User\UserLogic as UserUserLogic;
use Illuminate\Http\Request;
use UserLogic;

class LogicUserController extends Controller
{
    public function connect(Request $request){
        $func = $request->func;

        $user = new UserUserLogic;
        
        if($func == 'registration')
        {
            return $user->registration($request);
        }
        else if ($func == 'auth')
        {
            return $user->auth($request);
        }

        return '400 - Bad Request';
    }
}
