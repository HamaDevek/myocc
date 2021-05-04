<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\QandA;
use Illuminate\Http\Request;

class QAController extends Controller
{
    public function index()
    {
        $qa = QandA::where('qa_state',1)->orderBy('created_at','DESC')->get();
        return view('website.apps.qanda',['qa'=>$qa]);
    }
}
