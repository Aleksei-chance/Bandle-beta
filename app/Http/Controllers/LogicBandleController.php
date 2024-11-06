<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogicBandleController extends Controller
{
    public function connect(Request $request)
    {
        $func = $request->func;
    }
}
