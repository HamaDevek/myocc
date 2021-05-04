<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Order_InfoTable;
use Illuminate\Http\Request;
use \App\OrderTable;
class MyOrdersControllers extends Controller
{
    public function index()
    {
        $orders = Order_InfoTable::with('ordered')->where('oi_a_ID',session()->get('user'))->get();
        return view('website.apps.my-orders',['orders'=>$orders]);
    }
    public function show($id)
    {
        $orders = Order_InfoTable::with('ordered.item')->where('oi_a_ID',session()->get('user'))->where('oi_ID',$id)->firstOrFail();
        $countOrder = Order_InfoTable::with(
            ['ordered'=>function ($q)
            {
            $q
            ->with('item.type')
            ->where('o_group_by','<>',0);
            }])
            ->where('oi_a_ID',session()->get('user'))
            ->where('oi_ID',$id)
            ->firstOrFail();
            $count = [];
            foreach ($countOrder->ordered as $key => $value) {
                if(isset($count[$value->o_group_by])){
                   array_push($count[$value->o_group_by],$value);
                }else{
                    $count[$value->o_group_by] = [$value];
                }
            }
        // dd($count);
        return view('website.apps.ordered-items',['orders'=>$orders,'count'=>$count]);
    }
}
