<?php

namespace App\Http\Controllers;

use App\Logic\Bandle\BandleBlockLogic;
use App\Logic\Bandle\BandleLogic;
use Illuminate\Http\Request;

class LogicBandleBlockController extends Controller
{
    public function connect(Request $request)
    {
        $func = $request->func;
        $id = $bandle_id = 0;
        if($request->has('id'))
        {
            $id = $request->id;
        }
        if($request->has('bandle_id'))
        {
            $bandle_id = $request->bandle_id;
        }

        if ($func == 'items_load' && $request->has('bandle_id')) 
        {
            return BandleBlockLogic::items_load($bandle_id);
        }
        else if($func == 'item_content_load' && $request->has('id'))
        {
            return BandleBlockLogic::item_content_load($id);
        }

        else if($bandle_id > 0 && BandleLogic::access($bandle_id))
        {
            if ($func == 'item_add_modal') 
            {
                return BandleBlockLogic::item_add_modal($bandle_id);
            }
            else if ($func == 'item_add' && $request->has('block_type_id'))
            {
                return BandleBlockLogic::item_add($bandle_id, $request->block_type_id);
            }
        }

        else if($id > 0 && BandleBlockLogic::access($id))
        {
            if ($func == 'item_remove_modal') 
            {
                return BandleBlockLogic::item_remove_modal($id);
            }
        }

        

        return '400 - Bad Request';
    }
}
