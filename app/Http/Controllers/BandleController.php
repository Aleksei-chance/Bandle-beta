<?php

namespace App\Http\Controllers;

use App\Logic\Bandle\BandleLogic;
use Illuminate\Http\Request;

class BandleController extends Controller
{
    public function view($id, Request $request) {
        if(BandleLogic::access($id))
        {
            return view('bandle.index', BandleLogic::get_item($id));
        }
        return abort(404);
    }
}
