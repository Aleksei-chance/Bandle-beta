<?php

namespace App\Http\Controllers;

use App\Services\User\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function view()
    {
        return view('auth.index');
    }
}
