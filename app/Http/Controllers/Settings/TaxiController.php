<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TaxiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxi = \App\TaxiTable::all();
        $location = \App\LocationTable::where('l_state', 1)->get();
        //dd($location);
        if($location->count() > 0){
            return view('settings.apps.taxi')->with(['taxi'=>$taxi,'locations'=>$location]);
        }else{
            return view('settings.apps.taxi')->with(['taxi'=>$taxi,'locations'=>$location])->withErrors(['You dont have location !']);
        }
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
        $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->get();
        $loca = [];
            foreach ($location as $x) {
                array_push($loca, $x->l_ID);
            }
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            'phone' => 'required|digits:11',
            'car_number' => 'required|max:10',
            'car_model' => 'required|max:50',
            'locations' => 'required|in:'.implode(',',$loca),
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
    
        try { 
            $taxi = new \App\TaxiTable;
            $taxi->t_first_name = $request->input('firstname');
            $taxi->t_middle_name = $request->input('middlename');
            $taxi->t_last_name = $request->input('lastname');
            $taxi->t_phone = $request->input('phone');
            $taxi->t_car_ID = $request->input('car_number');
            $taxi->t_car_model = $request->input('car_model');
            $taxi->t_l_ID = $request->input('locations');
            $taxi->save();
            return redirect()->back()->with('success' , 'Done!');
          } catch(\Exception $ex){ 
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
        $taxis =\App\TaxiTable::all();
        $location = \App\LocationTable::wherelState(1)->get();
        $taxi = \App\TaxiTable::with('schedule.schedule')->wheretId($id)->first();
        $available = [];
        foreach ($taxi->schedule as $key => $value) {
            array_push($available,$value->schedule->w_ID);
        }
        $notAvailable =\App\WeekDays::whereNotIn('w_ID',$available)->get();
        return view('settings.apps.taxi')->with(['taxi'=>$taxis,'locations'=>$location,'edit' => $taxi,'days'=>$notAvailable]);
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
        $taxi= \App\TaxiTable::findOrFail($id);
        
        if($type == 1){
            if($taxi->t_state == 1){
                $taxi->t_state = 0;
                $taxi->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $taxi->t_state = 1;
                $taxi->save();
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
                'firstname' => 'required|max:255',
                'middlename' => 'required|max:255',
                'lastname' => 'required|max:255',
                'phone' => 'required|digits:11',
                'car_number' => 'required|max:10',
                'car_model' => 'required|max:50',
                'locations' => 'required|in:'.implode(',',$loca),
            ]);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput($request->input());
            }
            try{
            $taxi->t_first_name = $request->input('firstname');
            $taxi->t_middle_name = $request->input('middlename');
            $taxi->t_last_name = $request->input('lastname');
            $taxi->t_phone = $request->input('phone');
            $taxi->t_car_ID = $request->input('car_number');
            $taxi->t_car_model = $request->input('car_model');
            $taxi->t_l_ID = $request->input('locations');
            $taxi->t_state = empty($request->input('state')) ? 0 : 1 ;
            $taxi->save();
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
        $taxi= \App\TaxiTable::findOrFail($id);
        
        try{
            $taxi->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
    public function schedule_add(Request $request,$id)
     {

        $taxi = \App\TaxiTable::findOrFail($id)->with('schedule.schedule')->first();
        $available = [];
        foreach ($taxi->schedule as $key => $value) {
            array_push($available,$value->schedule->w_ID);
        }
        $notAvailable =\App\WeekDays::whereNotIn('w_ID',$available)->get();
        $validator = Validator::make($request->all(), [
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
           //'week' =>'required|not_in:'.implode(',',$notAvailable->pluck('w_ID')->toArray()).'|in:'.implode(',',$available),
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }
        try{
            $schedule = new \App\TaxiSchedule;
            $schedule->from = $request->input('from');
            $schedule->to = $request->input('to');
            $schedule->ts_t_ID = $id;
            $schedule->ts_w_ID = $request->input('week');
            $schedule->save();
            return redirect()->back()->with('success' , 'Done!');
        }catch(\Exception $ex){ 
            return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
        }

    }
    public function schedule_delete(Request $request,$id)
    {
        try{
            $schedule = \App\TaxiSchedule::findOrFail($id);
            $schedule->delete();
            return redirect()->back()->with('success' , 'Done!');
        }catch(\Exception $ex){ 
            return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
        }
    }
}
