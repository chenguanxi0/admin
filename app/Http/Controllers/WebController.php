<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Language;

class WebController extends Controller
{
    public function add(Request $request)
    {
        if ($request->method() == 'GET'){
            $languages = Language::all();
            return view('webs/add',compact('languages'));
        }

       return view('webs/add');
    }
}
