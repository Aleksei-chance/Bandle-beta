<?php

namespace App\Services\Bandle;

use App\Helpers\ResponsesHelper;
use App\Models\Bandle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BandleService
{
    public function create(int $user_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => ["required", 'string', 'max:100']
            , 'description' => ['nullable', 'string']
        ]);
        if ($validator->fails())
        {
            return ResponsesHelper::respondErrors($validator->errors()->messages());
        }
        $bandle = Bandle::query()->create(array_merge(['user_id' => $user_id], $validator->validated()));
        if($bandle)
        {
            return $bandle->id;
        }
        return 0;
    }
}
