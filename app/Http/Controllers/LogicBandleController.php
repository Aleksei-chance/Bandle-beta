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
            else if ($func == 'set_value_text' && $request->has('type') && $request->has('value'))
            {
                return BandleLogic::set_value_text($id, $request->type, $request->value);
            }
            else if ($func == 'item_remove')
            {
                return BandleLogic::item_remove($id);
            }
        }

        return '400 - Bad Request';
    }
}
