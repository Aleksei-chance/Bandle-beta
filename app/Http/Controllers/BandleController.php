<?php

namespace App\Http\Controllers;

use App\Logic\Bandle\BandleLogic;
use App\Services\Bandle\BandleService;
use Illuminate\Http\Request;

class BandleController extends Controller
{
    public function view($id, Request $request) {
        if(BandleService::access($id))
        {
            return view('bandle.index', (new BandleService($id))->get());
        }
        return abort(404);
    }
}
