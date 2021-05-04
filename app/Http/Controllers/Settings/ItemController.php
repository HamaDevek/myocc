<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\ItemTable::with(['type','image','colors.color','occation','shop'])->orderBy('created_at','DESC')->get();
        $shops = \App\ShopTable::whereshState(1)->get();
        $colors = \App\colorsTable::all();
        $occations = \App\OccationTable::where('oc_state',1)->get();
        $types = \App\TypeTable::where('tp_state' ,1)->get();
        return view('settings.apps.items')->with(
            [
                'items' => $items,
                'shops' => $shops,
                'occations' => $occations,
                'types' => $types,
                'colors' => $colors 
            ]);
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
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|max:255',
            'item_price' => 'required|max:20|regex:/[0-9]+/i',
            'item_desc' => 'required',
            'types' => 'required|in:'.implode(',',\App\TypeTable::select('tp_ID')->where('tp_state', 1)->pluck('tp_ID')->toArray()),
            'shops' =>'required|in:'.implode(',',\App\ShopTable::select('sh_ID')->where('sh_state', 1)->pluck('sh_ID')->toArray()),
            'occasions' =>'required|in:'.implode(',',\App\OccationTable::select('oc_ID')->where('oc_state', 1)->pluck('oc_ID')->toArray()),
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'img.image' => 'Image field must be image',
            'img.max' => 'Image field must be smaller than 2MB',
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
        try { 
        $item = new \App\ItemTable;
        $item->ip_name = $request->input('item_name');
        $item->ip_price = $request->input('item_price');
        $item->ip_description = $request->input('item_desc');
        $item->ip_tp_ID = $request->input('types');
        $item->ip_sh_ID = $request->input('shops');
        $item->ip_oc_ID = $request->input('occasions');
        $item->save();
        if(!is_null($request->img)){  
        $item_image= new \App\ImagesIpTable;
        $item_image->i_ip_ID =$item->ip_ID ;
        $item_image->i_link = $request->img->store('uploads','public');
        $item_image->i_is_primary =  1  ;
        $item_image->save();
        }
        return redirect()->back()->with('success' , 'Done!');
        } catch(\Exception $ex){ 
            
            return redirect()->back()->with('error' , 'Some things wrong ')->withInput($request->input());
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

        $NotInColor = \App\ItemTable::findOrFail($id)->with('colors.color')->first()->colors->all();
        $colorUsed = [];
        foreach ($NotInColor as $key => $value) {
            array_push($colorUsed,$value->color->c_ID);
        }
        $item = \App\ItemTable::with(['type','image','colors.color','occation','shop'])->findOrFail($id);
        $items = \App\ItemTable::with(['type','image','colors.color','occation','shop'])->get();
        $shops = \App\ShopTable::where('sh_state',1)->get();
        $colors = \App\colorsTable::whereNotIn('c_ID',$colorUsed)->get();
        $occations = \App\OccationTable::where('oc_state',1)->get();
        $types = \App\TypeTable::where('tp_state' ,1)->get();
       
        return view('settings.apps.items')->with(
            [
                'items' => $items,
                'shops' => $shops,
                'occations' => $occations,
                'types' => $types,
                'edit' => $item,
                'colors' => $colors 
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$type)
    {
        
        $item= \App\ItemTable::findOrFail($id);
        if($type == 1){
            if($item->ip_state == 1){
                $item->ip_state = 0;
                $item->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $item->ip_state = 1;
                $item->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 0){
            $validator = Validator::make($request->all(), [
                'item_name' => 'required|max:255',
                'item_price' => 'required|max:20|regex:/[0-9]+/i',
                'item_desc' => 'required',
                'types' => 'required|in:'.implode(',',\App\TypeTable::select('tp_ID')->where('tp_state', 1)->pluck('tp_ID')->toArray()),
                'shops' =>'required|in:'.implode(',',\App\ShopTable::select('sh_ID')->where('sh_state', 1)->pluck('sh_ID')->toArray()),
                'occasions' =>'required|in:'.implode(',',\App\OccationTable::select('oc_ID')->where('oc_state', 1)->pluck('oc_ID')->toArray()),
            ]);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput($request->input());
            }
            try { 
                $item = \App\ItemTable::findOrFail($id);
                $item->ip_name = $request->input('item_name');
                $item->ip_price = $request->input('item_price');
                $item->ip_description = $request->input('item_desc');
                $item->ip_tp_ID = $request->input('types');
                $item->ip_sh_ID = $request->input('shops');
                $item->ip_oc_ID = $request->input('occasions');
                $item->ip_state= empty($request->input('state')) ? 0 : 1 ;
                $item->save();
                return redirect()->back()->with('success' , 'Done!');
                } catch(\Exception $ex){ 
                    
                    return redirect()->back()->with('error' , 'Some things wrong ')->withInput($request->input());
                }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item= \App\ItemTable::findOrFail($id);
        $image= \App\ImagesIpTable::where('i_ip_ID',$id);
        $color= \App\ItemColorTable::where('ic_ip_ID',$id);
        try{
            $color->delete();
            $image->delete();
            $item->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect('/settings/item')->with('success' , 'Done!');
    }
    public function item_color(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'cols' => 'required',
        ],[
            'cols.required' => 'The Color field is required.'
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
        $item = \App\ItemTable::findOrFail($id)->first();
        $color = \App\ItemColorTable::where(['ic_c_ID'=>$request->input('cols'),'ic_ip_ID' => $id])->get()->toArray();
        $item_color= new \App\ItemColorTable;
        $item_color->ic_ip_ID = $id;
        $item_color->ic_c_ID = $request->input('cols') ;
        $item_color->save();

        
        if(!empty($color)){
            return redirect()->back()->with('error' , 'Some things wrong');
        }
        return redirect()->back()->with('success' , 'Done!');


    }
    public function item_image(Request $request,$id)
    {
    
            $request->validate([
                'imgs'=>'file|image|max:2000|required'
            ],[
                'imgs.file' => 'Image field must be file',
                'imgs.image' => 'Image field must be image',
                'imgs.max' => 'Image field must be smaller than 2MB',
                'imgs.required' => 'Image field must not empty',
            ]);
        
        $item = \App\ItemTable::findOrFail($id)->first();
        $is_primary = empty (\App\ImagesIpTable::where('i_ip_ID' , $id)->first());
        $item_image= new \App\ImagesIpTable;
        $item_image->i_ip_ID = $id ;
        $item_image->i_link = $request->imgs->store('uploads','public');
        $item_image->i_is_primary = $is_primary ? 1 : 0 ;
        $item_image->save();
  
        if(!empty($color)){
            return redirect()->back()->with('error' , 'Some things wrong');
        }
        return redirect()->back()->with('success' , 'Done!');


    }
    public function item_color_delete(Request $request,$id)
    {
        $color= \App\ItemColorTable::where('ic_ID',$id);
        try{
            $color->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');

    }
    public function item_image_delete(Request $request,$id)
    {
        $image= \App\ImagesIpTable::find($id);
          if(\File::exists(public_path('storage/'.$image->i_link))){
                \File::delete(public_path('storage/'.$image->i_link));
            }else{
                return redirect()->back()->with('error' , 'Some things wrong !');
            }
        try{
            $image->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');

    }
    public function item_image_update(Request $request,$id)
    {
        
        $images= \App\ImagesIpTable::find($id);
        $images->i_is_primary = 1;
        $images->save();

        $image = \App\ImagesIpTable::where('i_is_primary' , '1')->where('i_ip_ID',$images->i_ip_ID)->where('i_ID','<>',$images->i_ID)->first();
        $image->i_is_primary = 0;
        $image->save();
        
        return redirect()->back()->with('success' , 'Done!');
    }
}
