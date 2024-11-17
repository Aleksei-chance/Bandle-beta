<?php

namespace App\Http\Controllers;

use App\Actions\ProcessBandleAction;
use App\Actions\ProcessBlockAction;
use App\Actions\ProcessCollectionAction;
use App\Actions\ProcessUserAction;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function user(Request $request, ProcessUserAction $userAction)
    {
        return $userAction->execute($request);
    }
    public function collection(Request $request, ProcessCollectionAction $processCollectionAction)
    {
        return $processCollectionAction->execute($request);
    }
    public function bandle(Request $request, ProcessBandleAction $processBandleAction)
    {
        return $processBandleAction->execute($request);
    }
    public function block(Request $request, ProcessBlockAction $processBlockAction)
    {
        return $processBlockAction->execute($request);
    }
}
