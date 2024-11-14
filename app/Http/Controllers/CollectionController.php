<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function view(Request $request)
    {
        $arr = array(
            'id' => Auth::id()
            , 'type_id' => 1
        );
        return view('collection.index', $arr);
    }
}
