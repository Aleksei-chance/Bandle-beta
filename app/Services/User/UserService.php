<?php

namespace App\Services\User;

use Illuminate\Http\Request;

abstract class UserService
{
    public function create(Request $request)
    {
        echo 'yes';
    }
}