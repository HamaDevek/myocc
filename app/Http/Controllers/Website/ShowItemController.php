<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\AccountTable;
use \App\Web\ListCart;
use Illuminate\Support\Facades\DB;

class ShowItemController extends Controller
{
    public function show($id)
    {
        $item = \App\ItemTable::with(['type','image','colors.color','occation','shop'])->findOrFail($id);
       
        return view('website.apps.item')->with(['data' => $item]);
    }
    public function store(Request $request,$id)
    {
        
        $item = \App\ItemTable::where('ip_state',1)->findOrFail($id);
        $acc = AccountTable::where('a_ID',session()->get('user'))->firstOrFail();
    
        $data = $request->validate([
            'amounts' => 'required|max:3|regex:/^[1-9]\d*$/',
            ]);
            $order = ListCart::with('item.type')->where('c_ip_ID',$id)->where('c_a_ID',$acc->a_ID)->first();
            
            if(is_null($order)){
                $orderBsaket = new ListCart;
                $orderBsaket->c_ip_ID = $id;
                $orderBsaket->c_amount = $request->input('amounts');
                $orderBsaket->c_a_ID = $acc->a_ID;
                $orderBsaket->save();
            }else{
                if($order->item->type->tp_name == 'وەرەقە' || $order->item->type->tp_name == 'قردێلە'){
                    return \redirect()->back()->withError('ناتوانی زیادکردن ئەنجام بەیت بۆ ئەم کاڵایە');
                }
                if(($order->c_amount + $request->input('amounts')) < 999){
                    $order->c_amount = $order->c_amount + $request->input('amounts');
                    $order->save();
                    return \redirect()->route('order.carts')->withSuccess('زیادکردنەکە سەرکەوتوبوو');
                }else{
                    return \redirect()->back()->withError('بڕێکی زۆر زۆرت داوا کردووە تکایە ئاگاداربە');
                }
                
            }
           
            
            return \redirect()->route('order.carts')->withSuccess('هەڵگیرا');
    }
    public function edit(Request $request,$id)
    {
        
        $data = $request->validate([
            'amounts'=> 'required|max:3|regex:/^[1-9]\d*$/',
        ],[
            'amounts.regex'=>'تکایە ناتوانی کەمتر لە یەک داوا بکەیت',
            'amounts.required'=>'پێویستە ژمارەیەک داغڵ بکەیت',
            'amounts.max'=>'تکایە ناتوانی زیاتر لە 999 داوا بکەیت',
        ]);
            $order = ListCart::findOrFail($id);
            
            $fs = DB::table('list_carts')
            ->join('item_tables', 'item_tables.ip_ID', '=', 'list_carts.c_ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
            ->where('list_carts.c_a_ID',session()->get('user'))
            ->where('tp_name','<>','وەرەقە')
            ->where('tp_name','<>','قردێلە')
            ->where('c_ID',$id)
            ->get()
            ->first();
            if(!is_null($fs)){
                $order->c_amount = $request->input('amounts');
                $order->save();
            }else{
                return 'تکایە زیاد ناکرێ';
            }
            
            $groupBy = ListCart::with('item')->where('c_a_ID',session()->get('user'))->where('c_group_by',$order->c_group_by)->get();
            $all = 0;
            foreach ($groupBy as $key => $value) {
                $all = $all + ($value->item->ip_price * $value->c_amount);
            }
            $allItem = ListCart::with('item')->where('c_a_ID',session()->get('user'))->get();
            // dd($allItem);
             $all_price_order = 0;
             $all_amount_order = 0;
            foreach ($allItem as $key => $value) {
                $all_price_order = $all_price_order + ($value->item->ip_price * $value->c_amount);
                $all_amount_order = $all_amount_order +$value->c_amount;
            }



        return ['value'=>$order->c_amount * $fs->ip_price,'all'=>$all,'all_order'=>['all'=>$all_price_order,'amount'=>$all_amount_order ]] ;
    }

    public function carts()
    {
       
        $ac = AccountTable::where('a_ID',session()->get('user'))->firstOrFail();
        $acc = AccountTable::with(['oreder_temp.item.imageAvailable'])->where('a_ID',session()->get('user'))->firstOrFail();
        $countOrder = ListCart::with('item.type')->where('c_a_ID','=',$ac->a_ID)->where('c_group_by','<>',0)->orderBy('created_at','DESC')->get();
        $count = [];
        foreach ($countOrder as $key => $value) {
            if(isset($count[$value->c_group_by])){
               array_push($count[$value->c_group_by],$value);
            }else{
                $count[$value->c_group_by] = [$value];
            }
        }

        $info = ListCart::with(['item'=>function ($q)
        {            return $q->select(['ip_price','ip_ID']);
        }])->select(['c_ip_ID','c_amount'])->where('c_a_ID','=',$ac->a_ID)->get();
        $priceAll = 0;
        foreach ($info as $key => $value) {
            $priceAll = $priceAll  + ( $value->item->ip_price *  $value->c_amount);
        }
        $order_info =(object) [
            'amounts'=>array_sum($info->pluck('c_amount')->toArray()),
            'prices'=>$priceAll
        ];
        return view('website.apps.carts')->with(['orders' => $acc->oreder_temp,'account'=>$acc,'order_info'=>$order_info,'count'=>$count]);
        
    }
    public function destroy($id)
    {
        $groupBy = ListCart::select()->findOrFail($id)->c_group_by;
        $isDelete =DB::table('list_carts')
        ->join('item_tables', 'item_tables.ip_ID', '=', 'list_carts.c_ip_ID')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->where('c_group_by', $groupBy)
        ->where('c_ID',$id)
        ->first()
        ->tp_name;
        $orderBsaket = ListCart::findOrFail($id);
        if($isDelete != 'گوڵ'){
            $orderBsaket->delete();
        }else{
            $f = DB::table('list_carts')
            ->join('item_tables', 'item_tables.ip_ID', '=', 'list_carts.c_ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
            ->where('c_group_by', $groupBy)
            ->where('tp_name', '<>','گوڵ')
            ->get()
            ->count();
            $fs = DB::table('list_carts')
            ->join('item_tables', 'item_tables.ip_ID', '=', 'list_carts.c_ip_ID')
            ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
            ->where('c_group_by', $groupBy)
            ->where('tp_name','گوڵ')
            ->get()
            ->count();
            $bbc = true;
            if($fs > 1){
                $bbc = false;
                $orderBsaket->delete();
                return \redirect()->back()->withSuccess('بەسەکەووتوی جێبەجێ کرا');
            }
            if($f == 0){
                $bbc = false;
                $orderBsaket->delete();
                return \redirect()->back()->withSuccess('بەسەکەووتوی جێبەجێ کرا');
            }if($bbc){
                return \redirect()->back()->withError('تکایە بە لایەنی کەمەوە پێویستیت بە گوڵێک هەیە بۆ داوا کردن');
            }
        }
        
        return \redirect()->back()->withSuccess('بەسەکەووتوی جێبەجێ کرا');
    }
    public function redirectErrorEdit()
    {
        return redirect()->back()->withErrors('تکایە هەڵە روویداوە');
    }
    
}
