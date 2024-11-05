<?php

namespace App\Http\Controllers;

use App\Logic\User\UserLogic;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view($type)
    {
        if($type == 'bandle')
        {
            return view('user.index', ['type' => $type]);
        }

        return abort(404);
        // return view('user.bandle.items', UserLogic::get_bandles());
    }
}
