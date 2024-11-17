<?php

namespace App\Actions;

use App\Services\Bandle\BandleService;
use App\Services\Bandle\Block\BlockService;
use App\Services\Bandle\Block\NameBlockService;
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
            else if($func == 'set_value_text' && $request->has('type') && $request->has('value') && $request->has('block_type_id'))
            {
                $block_type_id = $request->block_type_id;
                $type = $request->type;
                $value = $request->value;
                if($block_type_id == 0)
                {
                    return (new BlockService($id))->set_value_text($type, $value);
                }
                else if($block_type_id == 1)
                {
                    return (new NameBlockService($id))->set_value_text($type, $value);
                }
            }
            else if($func == 'item_renew_modal')
            {
                return (new BlockService($id))->item_renew_modal();
            }
        }
        return '400 - Bad Request';
    }
}
