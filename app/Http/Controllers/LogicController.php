<?php

namespace App\Http\Controllers;

use App\Actions\User\ProcessUserAction;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function user(Request $request, ProcessUserAction $userAction)
    {
        return $userAction->execute($request);
    }
}
