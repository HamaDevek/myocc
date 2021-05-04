<?php

namespace App\Http\Controllers\Website;

use App\AccountTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAndFilterController extends Controller
{
    public function index()
    {
        $account = AccountTable::find(session()->get('user'));
        $type = \App\TypeTable::whereNotIn('tp_ID',[5,6,7])->get();
        $color =  \App\colorsTable::all();
        $occasion = \App\OccationTable::where('oc_state',1)->where('oc_ID','<>',1)->get();
        $item = DB::table('item_tables')
        ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
        ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
        ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
        ->where('i_is_primary', '=', 1)
        ->whereNotIn('ip_tp_ID', [5,6,7]);
        if(empty($account)){

        }else{
            $item->where(
                function ($q) use ($account)
                {
                    $q->where('sh_l_ID', '=', 1)
                    ->orWhere('sh_l_ID', '=', $account->a_l_ID);
                }
            );
        }
        // $item = \App\ItemTable::with(['shop'=>function ($q) use ($account)
        // {
        //     $q->where('sh_l_ID', '=', 1)
        //     ->orWhere('sh_l_ID', '=', $account->a_l_ID);
        // }])->get();

        return view('website.apps.filter',['type'=>$type ,'color'=>$color,'occasion'=>$occasion,'items'=>$item->get()]);
    }
    public function search(Request $request)
    {

        
        $account = AccountTable::find(session()->get('user'));
       
        $type = \App\TypeTable::whereNotIn('tp_ID',[5,6,7])->get();
        $color =  \App\colorsTable::all();
        $occasion = \App\OccationTable::where('oc_state',1)->where('oc_ID','<>',1)->get();
        $item = DB::table('item_tables')
        ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
        ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
        ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
        ->where('i_is_primary', '=', 1)
        ->whereNotIn('ip_tp_ID', [5,6,7]);
        if(empty($account)){

        }else{
            $item->where(
                function ($q) use ($account)
                {
                    $q->where('sh_l_ID', '=', 1)
                    ->orWhere('sh_l_ID', '=', $account->a_l_ID);
                }
            );
        }
        if($request->input('type')){
            $item->whereIn('ip_tp_ID',$request->input('type'));
        }
        if($request->input('color')){
            $item->join('item_color_tables', 'item_color_tables.ic_ip_ID', '=', 'item_tables.ip_ID')
            ->join('colors_tables', 'colors_tables.c_ID', '=', 'item_color_tables.ic_c_ID')
            ->whereIn('c_ID',$request->input('color'));
        }
        if($request->input('occasion')){
            $item->whereIn('ip_oc_ID',$request->input('occasion'));
        }
        //dd($item->get());
        return view('website.apps.filter',['type'=>$type ,'color'=>$color,'occasion'=>$occasion,'items'=>$item->get()]);
    }
}
