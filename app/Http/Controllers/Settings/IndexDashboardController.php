<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexDashboardController extends Controller
{
    public function index()
    {
        $data = DB::table('taxi_tables')
        ->join('send_taxi_tables' , 'send_taxi_tables.st_t_ID', '=','taxi_tables.t_ID')
        ->join('order_info_tables' , 'order_info_tables.oi_ID', '=','send_taxi_tables.st_oi_ID')
        ->where('oi_state',3)
        ->where('st_state',0)
        ->get();
        // dd($data);
        return view('settings.apps.dashboard.index',['taxi'=>$data]);
    }
}
