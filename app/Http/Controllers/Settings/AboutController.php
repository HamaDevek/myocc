<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = \App\Web\About::findOrFail(1);
        return view('settings.apps.about')->with(['about'=>$about ]);
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
            // 'imgs'=>'file|image|max:2000',
            'title' => 'required|max:255',
            'description' => 'required',
        ],[
            // 'imgs.file' => 'Image field must be file',
            // 'imgs.image' => 'Image field must be image',
            // 'imgs.max' => 'Image field must be smaller than 2MB',
            ]);
            
        $about = \App\Web\About::findOrFail(1);
        $about->title = $request->title;
        $about->desc = $request->description;
        // if(!is_null($request->imgs)){
        //      $about->image = $request->imgs->store('uploads','public');
        // }
        $about->save();
        return redirect()->back()->with('success' , 'Done!');
    }
    public function store_footer(Request $request)
    {
        $data = $request->validate([
            'footer_title' => 'required|max:255',
            'footer_description' => 'required',
        ],[
        'footer_description.required' => 'Description must be required',
        'footer_title.required' => 'Title must be required',
        'footer_title.max' => 'Title must be smaller than 255 latter',
        ]);
        $about = \App\Web\About::findOrFail(1);
        $about->footer_title = $request->footer_title;
        $about->footer_desc = $request->footer_description;
        $about->save();
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
