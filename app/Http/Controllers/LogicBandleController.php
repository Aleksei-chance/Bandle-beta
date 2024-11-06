<?php

namespace App\Http\Controllers;

use App\Logic\Bandle\BandleLogic;
use Illuminate\Http\Request;

class LogicBandleController extends Controller
{
    public function connect(Request $request)
    {
        $func = $request->func;

        if ($func == 'item_add_modal') 
        {
            return BandleLogic::item_add_modal();
        }
        else if ($func == 'item_add')
        {
            return BandleLogic::item_add($request);
        }

        return '400 - Bad Request';
    }
}
