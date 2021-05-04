<?php

namespace App\Http\Controllers\Settings;

use App\ContactAsTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactAsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = ContactAsTable::get()->first();
        return view('settings.apps.contact',['contact'=>$contact]);
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
        $data = $request->validate([
            'email'=>'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
        ]);
        $contact = ContactAsTable::findOrFail($id);
        $contact->con_address = $request->input('address');
        $contact->con_email = $request->input('email');
        $contact->con_phone = $request->input('phone');
        $contact->save();
        return redirect()->back()->withSuccess('Change Contact successfuly');
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
