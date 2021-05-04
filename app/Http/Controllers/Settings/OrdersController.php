<?php

namespace App\Http\Controllers\Settings;

use App\AccountTable;
use App\AdminTable;
use App\colorsTable;
use App\Http\Controllers\Controller;
use App\ItemTable;
use App\OccationTable;
use App\Order_InfoTable;
use App\OrderTable;
use App\SendTaxiTable;
use App\TaxiTable;
use App\TypeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = AdminTable::findOrFail(session()->get('dashboard'));
        $orders = Order_InfoTable::with(['location','owner'])->where(function ($q) use ($admin)
        {
            if($admin->ad_l_ID != 1){
                $q->where('oi_l_ID',$admin->ad_l_ID);
            }
        })->orderBy('oi_state','ASC')->get();
        return view('settings.apps.orders.orders',['orders'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('amount') <= 0){
            return redirect()->back()->withErrors('you have some error'); 
        }
        $data = $request->validate([
            'amount' => 'required|max:3',
            'group' => 'required',
            'item' => 'required',
        ]);
        
        $order = OrderTable::where('o_oi_ID',$request->input('order'))->where('o_ip_ID',$request->input('item'))->first();
        $item = ItemTable::with('type')->findOrFail($request->input('item'));

        
        if(is_null($order)){
            if( $request->input('group') == 0){
                if(in_array( $item->type->tp_ID,[5,6,7])){
                    return redirect()->back()->withErrors('you have some error');
                }
            $new = new OrderTable();
            $new->o_oi_ID = $request->input('order');
            $new->o_ip_ID = $item->ip_ID;
            $new->o_prices = $item->ip_price;
            $new->o_amount = $request->input('amount');
            $new->o_group_by = 0;
            $new->save();
            return redirect()->back()->withSuccess('Done');
            }else{
                
                if(!in_array( $item->type->tp_ID,[5,6,7])){
                    return redirect()->back()->withErrors('you have some error');
                }
                if(in_array( $item->type->tp_ID,[6,7])){
                    if($request->input('amount') > 1){
                        return redirect()->back()->withErrors('Amount must be 1');
                    }
                }
            $new = new OrderTable();
            $new->o_oi_ID = $request->input('order');
            $new->o_ip_ID = $item->ip_ID;
            $new->o_prices = $item->ip_price;
            $new->o_amount = $request->input('amount');
            $new->o_group_by = $request->input('group');
            $new->save();
            return redirect()->back()->withSuccess('Done');
            }
        }else{
            if(($order->o_amount + $request->input('amount')) <= 999){
                if(in_array( $item->type->tp_ID,[6,7])){
                    
                        return redirect()->back()->withErrors('You have This Item and amount must be 1 ');
                    
                }
                $order->o_amount = $order->o_amount + $request->input('amount');
                $order->save();
                return redirect()->back()->withSuccess('Done');
            }else{
                return redirect()->back()->withErrors('you have some error');
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = AdminTable::findOrFail(session()->get('dashboard'));
        $orders = Order_InfoTable::with(['ordered.item.type','location','owner'])->with(['ordered.item.image'=>function ($ql)
        {
            $ql->where('i_is_primary',1);
        }])->where(function ($q) use ($admin)
        {
            if($admin->ad_l_ID != 1){
                $q->where('oi_l_ID',$admin->ad_l_ID);
            }
        })->findOrFail($id);
        
        if( $orders->oi_state == 0){
            $day = substr(strtolower(date('l',strtotime($orders->oi_to_date.' '.$orders->oi_to_time))), 0, 3);
        $time = date('H:i',strtotime($orders->oi_to_time));
        $taxi = DB::table('taxi_tables')
        ->join('taxi_schedules','taxi_schedules.ts_t_ID' , '=' ,'taxi_tables.t_ID')
        ->join('week_days','week_days.w_ID' , '=' ,'taxi_schedules.ts_w_ID')
        ->where('week_days.w_days_enum', $day)
        ->where('taxi_schedules.from', '<=', $time)
        ->where('taxi_schedules.to', '>=', $time)
        ->where('taxi_tables.t_l_ID', $orders->oi_l_ID)
        ->get();
        

        //dd($orders->ordered->groupBy('o_group_by'));
        return view('settings.apps.orders.show',['orders'=>$orders,'taxi'=>$taxi]);
        }else if($orders->oi_state == 3){
            return view('settings.apps.orders.delivery',['orders'=>$orders->with(['ordered.item.type','taxi.taxi','owner'])->findOrFail($id)]);
        }else if($orders->oi_state == 2){
            return view('settings.apps.orders.rejected',['orders'=>$orders]);
        }else if($orders->oi_state == 1){
            return view('settings.apps.orders.done',['orders'=>$orders->with(['ordered.item.type','taxi.taxi','owner'])->findOrFail($id)]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$group)
    {
        
        $admin = AdminTable::findOrFail(session()->get('dashboard'));
        $order = OrderTable::where('o_oi_ID',$id)->where('o_group_by',$group)->get();
        if(count($order) == 0){
            return redirect()->back()->withErrors('you have some error');
        }
        if($group > 0){
            $type = TypeTable::whereIn('tp_ID',[5,6,7])->get();
            $color =  colorsTable::all();
            $item = DB::table('item_tables')
            ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
            ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
            ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')     
            ->where('i_is_primary', '=', 1)
            ->whereIn('shop_tables.sh_l_ID',[1,$admin->ad_l_ID])
            ->whereIn('ip_tp_ID', [5,6,7])
            ->whereNotIn('o_ip_ID',[])
            ->get();
            // dd($item);
            return view('settings.apps.orders.new',['type'=>$type ,'color'=>$color,'items'=>$item,'order'=>$id,'group'=>$group]);
        }else{
            $type = TypeTable::whereNotIn('tp_ID',[5,6,7])->get();
            $color =  colorsTable::all();
            $occasion = OccationTable::where('oc_state',1)->where('oc_ID','<>',1)->get();
            $item = DB::table('item_tables')
            ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
            ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
            ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
            ->where('i_is_primary', '=', 1)
            ->whereIn('shop_tables.sh_l_ID',[1,$admin->ad_l_ID])
            ->whereNotIn('ip_tp_ID', [5,6,7])
            ->get();
            // dd($item);
            return view('settings.apps.orders.new',['type'=>$type ,'color'=>$color,'occasion'=>$occasion,'items'=>$item,'order'=>$id,'group'=>$group]);
        }
    }
    public function search(Request $request,$id,$group)
    {
        
        $admin = AdminTable::findOrFail(session()->get('dashboard'));
        $order = OrderTable::where('o_oi_ID',$id)->where('o_group_by',$group)->get();
        if(count($order) == 0){
            return redirect()->back()->withErrors('you have some error');
        }
        if($group > 0){
            $type = TypeTable::whereIn('tp_ID',[5,6,7])->get();
            $color =  colorsTable::all();
            $item = DB::table('item_tables')
            ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
            ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
            ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')     
            ->where('i_is_primary', '=', 1)
            ->whereIn('shop_tables.sh_l_ID',[1,$admin->ad_l_ID])
            ->whereIn('ip_tp_ID', [5,6,7])
            ;
            if($request->input('type')){
                $item->whereIn('ip_tp_ID',$request->input('type'));
            }
            if($request->input('color')){
                $item->join('item_color_tables', 'item_color_tables.ic_ip_ID', '=', 'item_tables.ip_ID')
                ->join('colors_tables', 'colors_tables.c_ID', '=', 'item_color_tables.ic_c_ID')
                ->whereIn('c_ID',$request->input('color'));
            }
            // if($request->input('occasion')){
            //     $item->whereIn('ip_oc_ID',$request->input('occasion'));
            // }
            return view('settings.apps.orders.new',['type'=>$type ,'color'=>$color,'items'=>$item->get(),'order'=>$id,'group'=>$group]);
        }else{
            $type = TypeTable::whereNotIn('tp_ID',[5,6,7])->get();
            $color =  colorsTable::all();
            $occasion = OccationTable::where('oc_state',1)->where('oc_ID','<>',1)->get();
            $item = DB::table('item_tables')
            ->join('shop_tables', 'shop_tables.sh_ID', '=', 'item_tables.ip_sh_ID')
            ->join('occation_tables', 'occation_tables.oc_ID', '=', 'item_tables.ip_oc_ID')
            ->join('images_ip_tables', 'images_ip_tables.i_ip_ID', '=', 'item_tables.ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
            ->where('i_is_primary', '=', 1)
            ->whereIn('shop_tables.sh_l_ID',[1,$admin->ad_l_ID])
            ->whereNotIn('ip_tp_ID', [5,6,7])
            ;
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
            //dd($request->input());
            return view('settings.apps.orders.new',['type'=>$type ,'color'=>$color,'occasion'=>$occasion,'items'=>$item->get(),'order'=>$id,'group'=>$group]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $order = OrderTable::with('item.type')->findOrFail($id);
        
        if(in_array($order->item->type->tp_ID,[6,7])){
            return 'You cant change amount of this type';
        }
        $data = $request->validate([
            'amount' => 'required|max:3',
        ]);
        $order->o_amount = $request->input('amount');
        $order->save();
        return 'Updated Successfuly';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderTable::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Done');
    }
    public function sendtaxi(Request $request, $id)
    {
        if(empty(TaxiTable::find($request->input('taxi')))){
            return redirect()->back()->withError('Taxi not found');
        }
        $order = Order_InfoTable::findOrFail($id);
        $order->oi_state = 3;
        $order->save();
        $taxi = new SendTaxiTable();
        $taxi->st_t_ID = $request->input('taxi');
        $taxi->st_oi_ID = $id;
        $taxi->st_state = 0;
        $taxi->save();
        return redirect()->back()->withSuccess('Done');
    }
    public function reject($id)
    {
        $order = Order_InfoTable::findOrFail($id);
        $order->oi_state = 2;
        $order->save();
        return redirect()->back()->withSuccess('Done');
    }
    public function reject_delivery($order,$taxi)
    {
        
        $orders = Order_InfoTable::findOrFail($order);
        $orders->oi_state = 0;
        $orders->save();
        $send_taxi = SendTaxiTable::where('st_t_ID',$taxi)->where('st_oi_ID',$order)->where('st_state' , 0)->first();
        $send_taxi->st_state = 2; /// rejected
        $send_taxi->save();
        return redirect()->back()->withSuccess('Done');
    }
    public function accept_delivery($order,$taxi)
    {
        $orders = Order_InfoTable::findOrFail($order);
        $orders->oi_state = 1;
        $orders->save();
        $send_taxi = SendTaxiTable::where('st_t_ID',$taxi)->where('st_oi_ID',$order)->where('st_state' , 0)->first();
        $send_taxi->st_state = 1; /// accept
        $send_taxi->save();
        return redirect()->back()->withSuccess('Done');
    }
}
