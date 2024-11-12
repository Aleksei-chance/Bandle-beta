<?php

namespace App\Actions\User;

use App\Services\User\CreatorUserService;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class ProcessUserAction
{
    public function execute(Request $request)
    {
        $func = $request->func;
        if($func == 'create') {
            return (new CreatorUserService)->create($request);
        }
        else if ($func == 'authorise') {
            return (new CreatorUserService)->authorise($request);
        }

        return '400 - Bad Request';
    }
}