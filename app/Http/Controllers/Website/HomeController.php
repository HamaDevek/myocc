<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $extra = DB::table('home_extra')->first();

        $all =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->whereIn('ip_tp_ID',[1,2,3])
        ->orderBy('item_tables.created_at','DESC')
        ->limit(30)
        ->get();
        //return $all;
        $flower =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','چەپکە گوڵ')
        ->limit(10)
        ->orderBy('item_tables.created_at','DESC')
        ->get();
        $gift =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','دیاری')
        ->limit(10)
        ->orderBy('item_tables.created_at','DESC')
        ->get();
        $plant =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','ئینجانە')
        ->limit(10)
        ->orderBy('item_tables.created_at','DESC')
        ->get();
        $offer =DB::table('item_tables')
        ->join('type_tables', 'type_tables.tp_ID', '=', 'item_tables.ip_tp_ID')
        ->leftJoin('images_ip_tables', 'item_tables.ip_ID', '=', 'images_ip_tables.i_ip_ID')
        ->select('ip_ID AS value','ip_name AS name','ip_price  AS price',DB::raw('IFNULL(images_ip_tables.i_link, "'."image/placeholder.jpg".'") as image'))
        ->where('ip_state',1)
        ->where('images_ip_tables.i_is_primary',1)
        ->where('tp_name','ئۆفەر')
        ->limit(10)
        ->orderBy('item_tables.created_at','DESC')
        ->get();
        $banner = DB::table('homes')->get();

        return view('website.apps.home')->with(['banner'=>$banner,'all'=>$all,'gift' => $gift,'flower' => $flower,'plant'=>$plant,'offer'=>$offer ,'extra' => $extra]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
