<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  \App\AccountTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use \App\Web\ListCart;   
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $account = AccountTable::with('saved_location')->where('a_ID',session()->get('user'))->where('a_state',1)->firstOrFail();
        $location = \App\LocationTable::where('l_ID','<>',1)->where('l_state',1)->get();
        return view('website.apps.profile')->with(['account'=>$account,'location'=>$location]);
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
        $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->where('l_ID' , '<>', 1)->pluck('l_ID')->toArray();
        $user = AccountTable::with('location')->where('a_state', 1)->where('a_ID', $id)->firstOrFail();
        $list = ListCart::where(['c_a_ID'=>session()->get('user')])->get();
        
        
        
        $data = $request->validate([
            'name' => 'required|max:150',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //'phone' => 'required|max:17|phone|not_in:'.implode(',',\App\AccountTable::select('a_phone')->pluck('a_phone')->toArray()),
            'password' => 'required|max:50|min:6',
            'address' => 'required|max:50',
            'location' => 'required|in:'.implode(',',$location),
            ]);
        if($user->location->l_ID != $request->location){
            if(count($list) > 0){
                return \redirect()->back()->withErrors('ئەگەر شوێنی نیشتاجێ بوون بگۆریت ئەوە پێویستە سەبەتە بەتاڵ کرێتەوە');           
            }
        }
        if(Hash::check($request->input('password'),$user->a_password)){
        $user->a_name = $request->name;
        //$user->a_phone = $request->phone;
        $user->a_address = $request->address;
        $user->a_l_ID = $request->location;
        if(!is_null($request->image)){
            Storage::delete('public/'.$user->a_image);
            $user->a_image = $request->image->store('uploads','public');
        }
        $user->save();
            return  redirect()->back()->withSuccess('گۆڕانکاری ئەنجام درا');
        }else{
            return \redirect()->back()->with('error' , 'وشەی تێپەڕ هەڵەیە تکایە دڵنیا ببەرەوە لێی');
        }
        
        dd($request->input());
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
