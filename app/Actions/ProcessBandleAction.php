<?php

namespace App\Actions;

use App\Services\Bandle\BandleService;
use App\Services\Bandle\Block\BlockService;
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
            else if($func == 'items_load')
            {
                return (new BandleService($id))->items_load();
            }
            else if($func == 'item_add_modal')
            {
                return (new BandleService($id))->item_add_modal();
            }
            else if($func == 'item_add' && $request->has('block_type_id'))
            {
                return BlockService::create($id, $request->block_type_id);
            }
            else if($func == 'item_remove_modal' && $request->has('block_id'))
            {
                return BandleService::item_remove_modal($id, $request->block_id);
            }
        }
        return '400 - Bad Request';
    }
}
