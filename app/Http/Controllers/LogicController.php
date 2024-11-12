<?php

namespace App\Http\Controllers;

use App\Actions\User\UserAction;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function user(Request $request, UserAction $userAction)
    {
        return $userAction->execute($request);
    }
}
