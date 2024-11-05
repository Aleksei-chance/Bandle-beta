<?php

namespace App\Http\Controllers;

use App\Logic\User\UserLogic;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function bandle(Request $request) {
        return view('user.bandle.items', UserLogic::get_bandles());
    }
}
