<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\AccountTable;
use \App\SavedAddress;
use \App\Order_InfoTable;    
use \App\OrderTable;    
use \App\Web\ListCart;    
use Illuminate\Support\Facades\Validator;
class OrderControllerFinish extends Controller
{
    public function index($type)
    {
        $list = ListCart::where(['c_a_ID'=>session()->get('user')])->get();

        if(count($list) < 1){
            return \redirect()->back()->withErrors('هیچ کاڵایەکت نییە');

            
        }
        $address = \App\LocationTable::where('l_ID','<>',1)->where('l_state',1)->get();
        $add = AccountTable::with(['saved_location','location'])->findOrFail(session()->get('user'));
        $last_add = SavedAddress::where('sa_a_ID',session()->get('user'))->orderBy('created_at','DESC')->first();
        return view('website.apps.order')->with(['type'=>$type,'location'=>$add->saved_location,'loc'=>$add->location->l_name,'address'=>$address,'last_add'=>$last_add]);
    }

    public function done(Request $request,$type)
    {
        
        $acc = AccountTable::findOrFail(session()->get('user'));
        $address = \App\LocationTable::where('l_ID','<>',1)->where('l_state',1)->get();
        $info = ListCart::with(['item'])->where('c_a_ID','=',session()->get('user'))->get();
        $loc = [];
        foreach ($address as $key => $value) {
            array_push($loc,$value->l_ID);
        }
        $priceAll = 0;
        foreach ($info as $key => $value) {
            $priceAll = $priceAll  + ( $value->item->ip_price *  $value->c_amount);
        }

        $val = [
            'name_from' => 'required|max:255',
            'phone_from' => 'required|max:11',
            'address_from' => 'required|max:255',
            'message' => 'required|max:200',
            'date' => 'required|after:'. now()->subDay()->format("Y-m-d"),
            'time' => 'required',
        ];
        
        $res = [
            'name_from.required' => 'تکایە ناوێک داغڵ بکە',
            'phone_from.required' => 'تکایە ژمارەی مۆبایلێک داغڵ بکە',
            'address_from.required' => 'تکایە ناونیشانێک داغڵ بکە',
            'message.required' => 'تکایە پەیەمێک بنووسە',
            'name_from.max' =>'تکایە ناتوانی زیاتر لە ٢٥٥ پیت داغڵ بکەی',
            'phone_from.max' =>'تکایە ناتوانی زیاتر لە ١١ پیت داغڵ بکەی',
            'address_from.max' =>'تکایە ناتوانی زیاتر لە ٢٥٥ پیت داغڵ بکەی',
            'message.max' =>'تکایە ناتوانی زیاتر لە ٢٠٠ پیت داغڵ بکەی',
            'date.required' => 'تکایە ڕۆژی وەرگرتنەکە دیاری بکە',
            'time.required' => 'تکایە کاتی وەرگرتنەکە دیاری بکە',
            'time.after' => 'تکایە ١ کاتژمێر دوای ئێستە دیاری بکە',
        ];
 
        if($type == 1){
            $val['name_to'] = 'required|max:255';
            $val['phone_to'] = 'required|max:17';
            $val['address_to'] = 'required|max:255';
            $val['address_to_gift'] = 'required|in:'.implode(',',$loc);
        }
        if(date('Y-m-d',strtotime($request->date)) == now()->format("Y-m-d")){
            $val['time'] = 'required|after:'.now()->addHour()->format("H:i");
        }
       
        
        $data = $request->validate($val,$res);
    
        $orderInfo = new Order_InfoTable();
        $orderInfo->oi_type = $type;
        $orderInfo->oi_to_date = date('Y-m-d',strtotime($request->date));
        $orderInfo->oi_to_time = date('H:i',strtotime($request->time));
        $orderInfo->oi_name_from = $request->input('name_from');
        $orderInfo->oi_phone_from = $request->input('phone_from');
        $orderInfo->oi_address_from = $request->input('address_from');
        $orderInfo->oi_address_to = $request->input('address_to') ?? $request->input('address_from');
        $orderInfo->oi_masssage = $request->input('message');
        $orderInfo->oi_name_to = $request->input('name_to') ?? $request->input('name_from');
        $orderInfo->oi_phone_to = $request->input('phone_to') ?? $request->input('phone_from');
        $orderInfo->oi_l_ID = $request->input('address_to_gift') ?? $acc->a_l_ID;//address_to_gift
        $orderInfo->oi_a_ID = session()->get('user');
        $orderInfo->oi_state = 0;
        $orderInfo->oi_price_all = $priceAll;
        $orderInfo->save();

        foreach ($info as $key => $value) {
            $order = new OrderTable();
            $order->o_ip_ID = $value->item->ip_ID;
            $order->o_amount = $value->c_amount;
            $order->o_prices =  $value->item->ip_price;
            $order->o_group_by =  $value->c_group_by;
            $order->o_oi_ID = $orderInfo->oi_ID;
            $order->save();
            $value->delete();
        }
        return \redirect()->route('index')->withSuccess('سپاس بۆ هەڵبژاردنی مایئۆکەیژن داواکاریەکەت لە بەشی چاوەروانیە');
    }
    
    public function map($type)
    {
        return view('website.apps.map')->with(['type'=>$type]);
    }
    public function savedmap(Request $request,$type)
    {
        $account = AccountTable::findOrFail(session()->get('user'));
        $data = $request->validate([
            'lat' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'lng' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'name' => 'required|max:255'
        ]);
        $address = new SavedAddress();
        $address->sa_lng = $request->lng;
        $address->sa_lat = $request->lat;
        $address->sa_name = $request->name;
        $address->sa_a_ID = session()->get('user');
        $address->save();
        return \redirect()->route('submit.order',['type' => $type])->withSuccess('نەخشەکە هەڵگیرا');
    }
    public function deletemap(Request $request)
    {
        $account = AccountTable::with('saved_location')->findOrFail(session()->get('user'));
        $saved = [];
        foreach ($account->saved_location as $key => $value) {
            array_push($saved,$value->sa_ID);
        }
        $data = $request->validate([
            'saved_address'=> 'required|in:'.implode(',',$saved)
        ],[
            'saved_address.in' => 'تکایە ناونیشانێک هەڵبژێرە',
            'saved_address.required' => 'تکایە ناونیشانێک هەڵبژێرە'
        ]);
        SavedAddress::findOrFail($request->saved_address)->delete();
        return redirect()->back()->withSuccess('بە سەرکەوتوی سڕایەوە');
    }
 
}
