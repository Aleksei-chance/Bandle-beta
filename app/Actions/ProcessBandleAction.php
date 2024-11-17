<?php

namespace App\Actions;

use App\Services\Bandle\BandleService;
use Illuminate\Http\Request;

class ProcessBandleAction
{
    public function execute(Request $request)
    {
        $func = $request->func;
        $id = 0;
        if($request->has('id'))
        {
            $id = $request->id;
        }

        if($id > 0 && BandleService::access($id))
        {
            if($func == 'item_renew_modal')
            {
                return (new BandleService($id))->item_renew_modal();
            }
            else if($func == 'set_value_text' && $request->has('type') && $request->has('value'))
            {
                return  (new BandleService($id))->set_value_text($request->type, $request->value);
            }
        }
        return '400 - Bad Request';
    }
}
