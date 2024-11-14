<?php

namespace App\Actions;

use App\Services\Bandle\BandleService;
use App\Services\Collection\CreatorCollectionService;
use Illuminate\Http\Request;

class ProcessCollectionAction
{
    public function execute(Request $request)
    {
        $func = $request->func;
        $id = 0;
        if($request->has('id'))
        {
            $id = $request->id;
        }

        if($id > 0 && CreatorCollectionService::access($id))
        {
            if($func == 'page_load' && $request->has('type_id'))
            {
                return (new CreatorCollectionService($id))->page_load($request->type_id);
            }
            else if($func == 'item_add_modal')
            {
                return (new CreatorCollectionService($id))->item_add_modal();
            }
            else if($func == 'item_add')
            {
                return (new BandleService())->create($id, $request);
            }
        }
        return '400 - Bad Request';
    }
}
