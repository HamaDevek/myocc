<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = \App\TypeTable::all();
        return view('settings.apps.type')->with(['type'=>$type]);
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
            'type' => 'required|max:50',
        ]);
        $type = new \App\TypeTable;
        $type->tp_name = $request->type;
        $type->save();
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
        $types = \App\TypeTable::all();
        $type= \App\TypeTable::find($id);
        return view('settings.apps.type')->with(['type'=>$types,'edit' => $type]);
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
            return redirect()->back()->with('error' , 'you can not edit flowers');
        }
        $types= \App\TypeTable::find($id);
        
        if(empty($types)){
            return redirect()->back()->with('error' , 'Not found');
        }
        if($type == 1){
            if($types->tp_state == 1){
                $types->tp_state = 0;
                $types->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $types->tp_state = 1;
                $types->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 0){
            $data = $request->validate([
                'type' => 'required|max:50',
            ]);
            $types->tp_name = $request->type;
            $types->tp_state = empty($request->state) ? 0 : 1 ;
                $types->save();
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
            return redirect()->back()->with('error' , 'you can not delete flowers');
        }
        $type= \App\TypeTable::findOrFail($id);
        try{
            $type->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
}
