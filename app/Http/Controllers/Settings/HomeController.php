<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home = DB::table('homes')->get();
        $extra = DB::table('home_extra')->first();
        return view('settings.apps.home')->with(['home'=>$home,'extra'=>$extra]);
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
            'imgs'=>'file|image|max:2000|required',
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'clss' => 'required',
        ],[
            'imgs.file' => 'Image field must be file',
            'imgs.image' => 'Image field must be image',
            'imgs.max' => 'Image field must be smaller than 2MB',
            'imgs.required' => 'Image field must not empty',
        ]);
        $home = new \App\Web\Home;
        $home->image =  $request->imgs->store('uploads','public');
        $home->class = $request->clss == 0 ? 'left-align' : 'right-align';
        $home->title = $request->title;
        $home->desc = $request->subtitle;
        $home->save();
        return redirect()->back()->with('success' , 'Done!');

    }
    public function store_extra(Request $request)
    {
        
        $data = $request->validate([
            'imgss'=>'file|image|max:2000',
            'ceneter_title' => 'required|max:255',
        ],[
            'imgss.file' => 'Image field must be file',
            'imgss.image' => 'Image field must be image',
            'imgss.max' => 'Image field must be smaller than 2MB',
        ]);
        $dds = is_null($request->imgss) ? ['title'=> $request->input('ceneter_title')] : ['image' => $request->imgss->store('uploads','public') ,'title'=> $request->input('ceneter_title')];
        DB::table('home_extra')
        ->where('id', 1)
        ->update($dds);

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
        $home = \App\Web\Home::findOrFail($id)->delete();
        return redirect()->back()->with('success' , 'Done!');
    }
}
