<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $color = \App\colorsTable::all();
        return view('settings.apps.color')->with(['color'=>$color]);
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
        $color = \App\colorsTable::where('c_ID' , '>' , '0')->pluck('c_name')->toArray();
        //dd($color);
        $data = $request->validate([
            'color' => 'required|max:50',
            'name' => 'required|max:50|not_in:'.implode(',',$color),
        ]);
        $color = new \App\colorsTable;
        $color->c_name = $request->name;
        $color->c_color = $request->color;
        $color->save();
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
        $colors = \App\colorsTable::all();
        $color= \App\colorsTable::findOrFail($id);
        return view('settings.apps.color')->with(['color'=>$colors,'edit' => $color]);
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
        $color= \App\colorsTable::findOrFail($id);
        if($type == 0){
            $data = $request->validate([
                'name' => 'required|max:50',
                'color' => 'required|max:50',
            ]);
            $color->c_name = $request->name;
            $color->c_color = $request->color;
            $color->save();
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
        $color= \App\colorsTable::findOrFail($id);
        try{
            $color->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }

    
}
