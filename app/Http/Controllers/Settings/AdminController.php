<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $admin = \App\AdminTable::where('ad_ID','<>' ,session()->get('dashboard'))->where('ad_ID','<>' ,1)->get();
        $location = \App\LocationTable::where('l_state', 1)->get();
        if($location->count() > 0){
            return view('settings.apps.admin')->with(['user'=>$admin,'locations'=>$location]);
        }else{
            return view('settings.apps.admin')->with(['user'=>$admin,'locations'=>$location])->withErrors(['You dont have location !']);
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
            'password' => 'required|max:50|min:6',
            'confirm_password' => 'required|max:50|min:6|same:password',
            'locations' => 'required|in:'.implode(',',$loca),
            'role' => 'required|in:0,1',
            
        ]);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->input());
        }

        if(count(\App\AdminTable::select('ad_ID')->where('ad_phone', $request->input('phone'))->get()) > 0){
            return redirect()->back()->with('error' , 'Some things wrong ! maybe Dublicate some unique data')->withInput($request->input());
        }else{
            try { 
                $isExist = \App\AdminTable::select('ad_ID')->latest('ad_ID')->where('ad_username', 'like', '%' . $request->input('firstname') . '%')->get();
                $user = new \App\AdminTable;
                $user->ad_first_name = $request->input('firstname');
                $user->ad_middle_name = $request->input('middlename');
                $user->ad_last_name = $request->input('lastname');
                $user->ad_phone = $request->input('phone');
                $user->ad_password = Hash::make($request->input('password'));
                $user->ad_l_ID = $request->input('locations');
                $user->ad_role = $request->input('role');
                $isExist = count($isExist) == 0 ? '': count($isExist);
                //dd($isExist);
                $user->ad_username =  strtolower($request->input('firstname')).''.$isExist;
                $user->save();
                return redirect()->back()->with('success' , 'Done!');
              } catch(\Exception $ex){ 
                  //dd($ex);
                return redirect()->back()->with('error' , 'Some things wrong !')->withInput($request->input());
              }
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
        $users = \App\AdminTable::where('ad_ID','<>' ,session()->get('dashboard'))->get();
        $location = \App\LocationTable::where('l_state', 1)->get();
        $user= \App\AdminTable::find($id);
        return view('settings.apps.admin')->with(['user'=>$users,'locations'=>$location,'edit' => $user]);
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
        $user= \App\AdminTable::where('ad_ID','<>' ,session()->get('dashboard'))->where('ad_ID',$id)->first();
        if(empty($user)){
            return redirect()->back()->with('error' , 'Not found');
        }
        if($type == 0){
            $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->get();
            $loca = [];
            foreach ($location as $x) {
                array_push($loca, $x->l_ID);
            }
            $username = \App\AdminTable::where('ad_ID', '!=', $user->ad_ID)->get();
            $users = [];
            foreach ($username as $x) {
                array_push($users, $x->ad_username);
            }
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:255',
                'middlename' => 'required|max:255',
                'lastname' => 'required|max:255',
                'phone' => 'required|digits:11',
                'username' => 'required|max:50|not_in:'.implode(',',$users),
                'role' => 'required|in:0,1',
                'locations' => 'required|in:'.implode(',',$loca),
            ],
            [
                'username.not_in' => 'Username taken !'
            ]
            );
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput($request->input());
            }
            $user->ad_first_name = $request->input('firstname');
            $user->ad_middle_name = $request->input('middlename');
            $user->ad_last_name = $request->input('lastname');
            $user->ad_phone = $request->input('phone');
            $user->ad_l_ID = $request->input('locations');
            $user->ad_role = $request->input('role');
            $user->ad_state = empty($request->input('state')) ? 0 : 1;
            $user->save();
            return redirect()->back()->with('success' , 'Done!');
        }
        if($type == 1){
            if($user->ad_state == 1){
                $user->ad_state = 0;
                $user->save();
                return redirect()->back()->with('success' , 'Done!');
            }else{
                $user->ad_state = 1;
                $user->save();
                return redirect()->back()->with('success' , 'Done!');
            }
        }
        if($type == 2){
            $data = $request->validate([
                'new_password' => 'required|max:50|min:6',
                'confirm_password' => 'required|max:50|same:new_password',
            ]);
            $user->ad_password = Hash::make($request->input('new_password'));
            $user->save();
            return redirect()->back()->with('success' , 'Done!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= \App\AdminTable::where('ad_ID',$id)->where('ad_ID','<>' ,session()->get('dashboard'))->first();
        if(empty($user)){
            return redirect()->back()->with('error' , 'Not found');
        }
        try{
            $user->delete();
        }catch(\Exception $e){
            return redirect()->back()->with('error' , 'Some things wrong !');
        }
        return redirect()->back()->with('success' , 'Done!');
    }
}
