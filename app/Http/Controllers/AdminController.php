<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        Storage::disk('local')->put('file.txt', 'Contents');
        return view('index');
    }

}
