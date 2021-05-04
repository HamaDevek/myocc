<?php

namespace App\Http\Controllers\Settings;

use App\AccountTable;
use App\AdminTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = AdminTable::find(session()->get('dashboard'));
        if($admin->ad_l_ID == 1){
            $account = AccountTable::with(['location'])->orderBy('a_state','ASC')->get();
        }else{
            $account = AccountTable::with(['location'])->where('a_l_ID',$admin->ad_l_ID)->orderBy('a_state','ASC')->get();
        }
        return view('settings.apps.user.index',['accounts'=>$account]);
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

        $account = AccountTable::findOrFail($id);
        $account->a_state = $request->input('state');
        $account->save();
        $data = $request->validate([
            'state' => 'required|in:'.implode(',',[1,2]),
        ]);
        return redirect()->back()->withSuccess('Done');
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
