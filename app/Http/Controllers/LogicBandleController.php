<?php

namespace App\Http\Controllers;

use App\Logic\Bandle\BandleLogic;
use Illuminate\Http\Request;

class LogicBandleController extends Controller
{
    public function connect(Request $request)
    {
        $func = $request->func;
        $id = 0;
        if($request->has('id'))
        {
            $id = $request->id;
        }

        if ($func == 'item_add_modal') 
        {
            return BandleLogic::item_add_modal();
        }
        else if ($func == 'item_add')
        {
            return BandleLogic::item_add($request);
        }

        if($id > 0 && BandleLogic::access($id))
        {
            if ($func == 'item_renew_modal')
            {
                return BandleLogic::item_renew_modal($id);
            }
        }

        return '400 - Bad Request';
    }
}
