<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $location = \App\LocationTable::all();
        return view('settings.apps.location')->with(['location'=>$location]);
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
        $data = $request->validate([
            'location' => 'required|max:50',
        ]);
        $location = new \App\LocationTable;
        $location->l_name = $request->location;
        $location->save();
        return redirect()->back()->with('success' , 'Done!');
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
        if($id == 1){
            return redirect()->back()->with('error' , 'You can not Edit default System Information');
        }
        $locations = \App\LocationTable::all();
        $location= \App\LocationTable::findOrFail($id);
        return view('settings.apps.location')->with(['location'=>$locations,'edit' => $location]);
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
        $location= \App\LocationTable::findOrFail($id);
        if($type == 1){
            if($location->l_state == 1){
                $location->l_state = 0;
                $location->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $location->l_state = 1;
                $location->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 0){
           
            $data = $request->validate([
                'location' => 'required|max:50',
            ]);
            $location->l_name = $request->location;
            $location->l_state = empty($request->state) ? 0 : 1 ;
                $location->save();
                return redirect()->back()->with('success' , 'Done!');
    
        }
        
        return abort(404);
        
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
        if($id == 1){
            return redirect()->back()->with('error' , 'You can not Edit default System Information');
        }
        $location= \App\LocationTable::findOrFail($id);
        try{
            $location->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
}
