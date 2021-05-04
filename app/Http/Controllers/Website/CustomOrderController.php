<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\AccountTable;
use \App\ItemTable;
use \App\TypeTable;
use \App\Web\ListCart;
class CustomOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flower =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','گوڵ')
        ->limit(10)
        ->get();
        $wrapper =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','وەرەقە')
        ->limit(10)
        ->get();
        $lace =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','قردێلە')
        ->limit(10)
        ->get();
        $acc = AccountTable::with(['oreder_temp_custom'])->where('a_ID',session()->get('user'))->firstOrFail();

        return view('website.apps.custom')->with(['flower'=>$flower,'wrapper'=>$wrapper,'lace'=>$lace]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $qrdela = TypeTable::with('items')->where('tp_name','قردێلە')->firstOrFail();
        $waraqa = TypeTable::with('items')->where('tp_name','وەرەقە')->firstOrFail();
        $waraqaID = [];
        foreach ($waraqa->items as $key => $value) {
            array_push($waraqaID,$value->ip_ID);
        }
        $qrdelaID = [];
        foreach ($qrdela->items as $key => $value) {
            array_push($qrdelaID,$value->ip_ID);
        }
        if(isset($request->waraqa)){
            foreach (array_keys($request->waraqa) as $key => $value) {
                if(!in_array($value, $waraqaID)){
                    return \redirect()->back()->withError('هەڵەیەک ڕویداوە تکایە دوبارە هەوڵ بدەرەوە');
                }
            }
        }
        if(isset($request->qrdela)){
            foreach (array_keys($request->qrdela) as $key => $value) {
                if(!in_array($value, $qrdelaID)){
                    return \redirect()->back()->withError('هەڵەیەک ڕویداوە تکایە دوبارە هەوڵ بدەرەوە');
                }
            }
        }
        $f = [];
        foreach ($request->item as $key => $value) {
            if($value > 0){
                if( $value <= 999){
                    $f[$key] =  $value;
                    
                }
            }
        }
        if(count($f) < 1){
            return \redirect()->back()->withError('تکایە بە لایەنی کەمەوە گوڵێک هەڵبژێرە');
        }
       
        $w = isset($request->waraqa) ? array_keys($request->waraqa) : [];
        $l = isset($request->qrdela) ? array_keys($request->qrdela) : [];
        $acc = AccountTable::where('a_ID',session()->get('user'))->firstOrFail();
        $max = ListCart::where('c_a_ID',$acc->a_ID)->max('c_group_by')+1;
        $or =array_merge($w,$l);
        $data = [];
        foreach ($or as $key => $value) {
            array_push($data,['c_ip_ID'=>$value, 'c_amount'=> 1,'c_a_ID'=> $acc->a_ID,'c_group_by'=>$max,'created_at'=>now(),'updated_at'=>now()]);
        }
        foreach ($f as $key => $value) {
            array_push($data,['c_ip_ID'=>$key, 'c_amount'=> $value,'c_a_ID'=> $acc->a_ID,'c_group_by'=>$max,'created_at'=>now(),'updated_at'=>now()]);
        }
        //dd($data);
        ListCart::insert($data);
        return \redirect()->route('order.carts')->withSuccess('زیادکردنەکە سەرکەوتوبوو');    
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ListCart::where('c_group_by',$id)->delete();
        return \redirect()->back()->withSuccess('بەسەکەووتوی جێبەجێ کرا');
    }
}
