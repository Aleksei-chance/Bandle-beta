<?php

namespace App\Http\Controllers;

use App\Logic\User\UserLogic as UserUserLogic;
use Illuminate\Http\Request;
use UserLogic;

class ApiUserController extends Controller
{
    public function connect(Request $request){
        $func = $request->func;

        $user = new UserUserLogic;
        
        if($func == 'registration')
        {
            return $user->registration($request);
        }

        return '400 - Bad Request';
    }
}
