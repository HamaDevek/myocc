<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $shop = \App\ShopTable::all();
        $location = \App\LocationTable::where('l_state', 1)->get();
        if($location->count() > 0){
            return view('settings.apps.shop')->with(['shop'=>$shop,'locations'=>$location]);
        }else{
            return view('settings.apps.shop')->with(['shop'=>$shop,'locations'=>$location])->withErrors(['You dont have location !']);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->get();
        $loca = [];
            foreach ($location as $x) {
                array_push($loca, $x->l_ID);
            }
    
        
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|max:255',
            'owner_name' => 'required|max:255',
            'phone' => 'required|digits:11',
            'locations' => 'required|in:'.implode(',',$loca),
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
    
        try { 
            $shop = new \App\ShopTable;
            $shop->sh_name = $request->input('shop_name');
            $shop->sh_owner = $request->input('owner_name');
            $shop->sh_phone = $request->input('phone');
            $shop->sh_l_ID = $request->input('locations');
            $shop->save();
            return redirect()->back()->with('success' , 'Done!');
          } catch(\Illuminate\Database\QueryException $ex){ 
              //dd($ex);
            return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
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
        if($id == 1){
            return redirect()->back()->with('error' , 'You can not Edit default System Information');
        }
        $shops = \App\ShopTable::all();
        $location = \App\LocationTable::where('l_state', 1)->get();
        $shop= \App\ShopTable::with('schedule.schedule')->whereshId($id)->first();
        $available = [];
        foreach ($shop->schedule as $key => $value) {
            array_push($available,$value->schedule->w_ID);
        }
        
        $notAvailable =\App\WeekDays::whereNotIn('w_ID',$available)->get();
        return view('settings.apps.shop')->with(['shop'=>$shops,'locations'=>$location,'edit' => $shop,'days'=>$notAvailable]);
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
        if($id == 1){
            return redirect()->back()->with('error' , 'You can not Edit default System Information');
        }
        $shop= \App\ShopTable::findOrFail($id);
        
        if($type == 1){
            if($shop->sh_state == 1){
                $shop->sh_state = 0;
                $shop->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $shop->sh_state = 1;
                $shop->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 0){
            $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->get();
            $loca = [];
                foreach ($location as $x) {
                    array_push($loca, $x->l_ID);
                }
            $validator = Validator::make($request->all(), [
                'shop_name' => 'required|max:255',
                'owner_name' => 'required|max:255',
                'phone' => 'required|digits:11',
                'locations' => 'required|in:'.implode(',',$loca),
            ]);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput($request->input());
            }
            try{
            $shop->sh_name = $request->input('shop_name');
            $shop->sh_owner = $request->input('owner_name');
            $shop->sh_phone = $request->input('phone');
            $shop->sh_l_ID = $request->locations;
            //dd( $request->locations);
            $shop->sh_state = empty($request->input('state')) ? 0 : 1 ;
            $shop->save();
            return redirect()->back()->with('success' , 'Done!');
            }catch(\Exception $ex){ 
              return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
            }
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1){
            return redirect()->back()->with('error' , 'You can not delete default System Information');
        }
        $shop= \App\ShopTable::find($id);
        if(empty($shop)){
            return redirect()->back()->with('error' , 'Not found');
        }
        try{
            $shop->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
    public function schedule_add(Request $request,$id)
    {
        $shop = \App\ShopTable::findOrFail($id)->with('schedule.schedule')->first();
        
        $available = [];
        foreach ($shop->schedule as $key => $value) {
            array_push($available,$value->schedule->w_ID);
        }
        $notAvailable =\App\WeekDays::whereNotIn('w_ID',$available)->get();
        $validator = Validator::make($request->all(), [
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
            'week' =>'required|in:'.implode(',',$notAvailable->pluck('w_ID')->toArray()).'|not_in:'.implode(',',$available),
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
        try{
            $schedule = new \App\ShopSchedule;
            $schedule->from = $request->input('from');
            $schedule->to = $request->input('to');
            $schedule->shs_sh_ID = $id;
            $schedule->shs_w_ID = $request->input('week');
            $schedule->save();
            return redirect()->back()->with('success' , 'Done!');
        }catch(\Exception $ex){ 
            return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
        }
    }
   public function schedule_delete(Request $request,$id)
   {
    try{
        $schedule = \App\ShopSchedule::findOrFail($id);
        $schedule->delete();
        return redirect()->back()->with('success' , 'Done!');
    }catch(\Exception $ex){ 
        return redirect()->back()->with('error' , 'Some things wrong')->withInput($request->input());
    }
   }
}
