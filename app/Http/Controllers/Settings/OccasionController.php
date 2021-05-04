<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $occasion = \App\OccationTable::all();
        return view('settings.apps.occasion')->with(['occasion'=>$occasion]);
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
            'occasion' => 'required|max:50',
        ]);
        $occasion = new \App\OccationTable;
        $occasion->oc_name = $request->occasion;
        $occasion->save();
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
        $occasions = \App\OccationTable::all();
        $occasion= \App\OccationTable::find($id);
        return view('settings.apps.occasion')->with(['occasion'=>$occasions,'edit' => $occasion]);
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
        $occasion= \App\OccationTable::findOrFail($id);
        if($type == 1){
            if($occasion->oc_state == 1){
                $occasion->oc_state = 0;
                $occasion->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $occasion->oc_state = 1;
                $occasion->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 0){
            $data = $request->validate([
                'occasion' => 'required|max:50',
            ]);
            $occasion->oc_name = $request->occasion;
            $occasion->oc_state = empty($request->state) ? 0 : 1 ;
                $occasion->save();
                return redirect()->back()->with('success' , 'Done!');
    
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
            return redirect()->back()->with('error' , 'You can not Edit default System Information');
        }
        $occasion= \App\OccationTable::findOrFail($id);
       
        try{
            $occasion->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
}
