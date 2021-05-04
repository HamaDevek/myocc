<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermAndCond extends Controller
{
    public function index()
    {
        $about = \App\Web\About::findOrFail(2);
        return view('website.apps.about')->with(['about'=>$about]);
    
    }
}
