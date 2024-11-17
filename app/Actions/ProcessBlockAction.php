<?php

namespace App\Actions;

use App\Services\Bandle\BandleService;
use App\Services\Bandle\Block\BlockService;
use Illuminate\Http\Request;

class ProcessBlockAction
{
    public function execute(Request $request)
    {
        $func = $request->func;
        $id = 0;
        if($request->has('id'))
        {
            $id = $request->id;
        }

        if($id > 0 && BlockService::access($id))
        {
            if($func == 'item_content_load')
            {
                return (new BlockService($id))->load_content();
            }
        }
        return '400 - Bad Request';
    }
}
