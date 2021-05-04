<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Common;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use  \App\AccountTable;
use Nexmo\Laravel\Facade\Nexmo;

class AuthenticationController extends Controller
{
    public function index()
    {

        if (session()->exists('user')) {
            return redirect('/');
        }
        return view('website.apps.login');
    }
    public function login(Request $request)
    {


        // $res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ldx190UAAAAANQojnYOiXXBpIVYJOIzRdW95gtA&response=".$request->input('g-recaptcha-response')."&remoteip".$_SERVER['REMOTE_ADDR']);
        // $res = json_decode($res);
        // if(!$res->success){
        //     return redirect()->back()->withErrors('من ڕۆبۆت نیم چێک بکە');
        // }

        $data = $request->validate([
            'phone' => 'required|digits:11',
            'password' => 'required|max:50',
        ], [
            'phone.required' => 'تکایە ژمارە مۆبایلەکەت داغڵ بکە',
            'password.required'  => 'تکایە وشەی تێپەڕ داغڵ بکە',
        ]);
        $user = \App\AccountTable::where('a_phone', $request->input('phone'))->first();
        if (\is_null($user)) {
            return redirect()->back()->withErrors('ژمارە یان وشەی تێپەڕ هەلەیە');
        }
        if ($user->a_state == 0) {
            return redirect()->route('login.verify', ['id' => $user->a_ID])->withErrors('هەژماەرەکەت چالاک نییە');
        } else {
            if ($user->a_state == 1) {
                if (Hash::check($request->input('password'), $user->a_password)) {
                    session()->put('user', $user->a_ID);
                    return  redirect('/');
                } else {
                    return \redirect()->back()->with('error', 'ژمارە یان وشەی تێپەڕ هەلەیە');
                }
            } else {
                return redirect()->back()->withErrors('هەژمارەکەت لە کار کەوتووە تکایە پەیووەندیمان پێوە بکە');
            }
            return redirect()->back();
        }
    }
    public function register(Request $request)
    {
        // $res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ldx190UAAAAANQojnYOiXXBpIVYJOIzRdW95gtA&response=" . $request->input('g-recaptcha-response') . "&remoteip" . $_SERVER['REMOTE_ADDR']);
        // $res = json_decode($res);
        // if (!$res->success) {
        //     return redirect()->back()->withErrors('من ڕۆبۆت نیم چێک بکە');
        // }
        try {
            $rand = new Common();
            $location = \App\LocationTable::select('l_ID')->where('l_state', 1)->where('l_ID', '<>', 1)->pluck('l_ID')->toArray();
            $account = \App\AccountTable::select('a_phone')->pluck('a_phone')->toArray();

            $data = $request->validate([
                'name' => 'required|max:150',
                'imgs' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'phone' => 'required|digits:11|not_in:' . implode(',', $account),
                'password' => 'required|max:50|min:6',
                'password_verify' => 'required|same:password|max:50',
                'address' => 'required|max:50',
                'location' => 'required|in:' . implode(',', $location),
            ]);


            $user = new \App\AccountTable;
            $user->a_name = $request->name;
            $user->a_password = Hash::make($request->password);
            $user->a_phone = $request->phone;
            $user->a_address = $request->address;
            $user->a_state = 0;
            $user->a_l_ID = $request->location;
            $user->a_image = empty($request->imgs) ? null :  $request->imgs->store('uploads', 'public');
            $user->save();
            $random = $rand->randomCode(5);
            // Nexmo::message()->send([
            //     'to'   => '+9647501594292',
            //     'from' => '+9647501594292',
            //     'text' => 'The verification code :' . $random
            // ]);
            $getUser = \App\AccountTable::where('a_phone', $request->input('phone'))->first();
            $verify = new \App\VerificationTable;
            $verify->v_code = $random;
            $verify->v_a_ID = $getUser->a_ID;
            $verify->save();
            return redirect()->route('login.verify', ['id' => $getUser->a_ID]);
        } catch (\Illuminate\Foundation\Bootstrap\HandleExceptions $ex) {
            return redirect()->back()->withError('شتێکی هەڵە هەیە');
        }
    }
    public function registerShow()
    {
        if (session()->exists('user')) {
            return redirect('/');
        }
        $location = \App\LocationTable::where('l_ID', '<>', 1)->where('l_state', 1)->get();
        return view('website.apps.register')->with(['location' => $location]);
    }
    public function logout()
    {
        if (session()->exists('user')) {
            session()->forget('user');
            session()->save();
            return redirect('/')->withSuccess('سپاس بۆ بەکار هێنانی مایئۆکەیژن');
        }
        return redirect('/');
    }
    public function verify($id)
    {
        if (session()->exists('user')) {
            return redirect('/');
        }
        $getUser = \App\AccountTable::findOrFail($id);
        return view('website.apps.verify')->with(['id' => $id]);
    }
    public function check(Request $request, $id)
    {
        if (session()->exists('user')) {
            return redirect('/');
        }
        $getUser = \App\AccountTable::with('code')->findOrFail($id);
        if ($getUser->code->v_code == $request->input('code')) {
            session()->put('user', $getUser->a_ID);
            \App\VerificationTable::findOrFail($getUser->code->v_ID)->delete();
            $getUser->a_state = 1;
            $getUser->save();
            return \redirect('/')->with('success', 'بە سەرکەوتووی هەژمارەکەت دروست کرا');
        } else {
            return redirect()->back()->withError('Please be check your inbox again');
        }
    }
    public function passwordshow()
    {
        return view('website.apps.changepassword');
    }
    public function passwordchange(Request $request)
    {
        $user = AccountTable::where('a_state', 1)->where('a_ID', session()->get('user'))->firstOrFail();
        $data = $request->validate([
            'password' => 'required',
            'password_new' => 'required|max:50|min:6',
            'password_verify' => 'required|same:password_new',
        ], [
            'password.required' => 'تکایە پاسۆردی کۆن داغڵ بکە',
            'password_new.required' => 'تکایە پاسۆردی نوێ داغڵ بکە',
            'password_new.max' => 'تکایە پاسۆردەکەت ٥٠ پیت زیاتر وەرناگرێت',
            'password_new.min' => 'تکایە پاسۆردەکەت ٦ پیت کەمتر وەرناگرێت',
            'password_verify.required' => 'تکایە پاسۆردی دڵنیایی داغڵ بکە',
            'password_verify.same' => 'پاسۆردی دڵنیاییت هەڵەیە',
        ]);
        if (Hash::check($request->input('password'), $user->a_password)) {
            $user->a_password = Hash::make($request->input('password_new'));
            $user->save();
            return  redirect()->back()->withSuccess('گۆڕانکاری ئەنجام درا');
        } else {
            return \redirect()->back()->with('error', 'وشەی تێپەڕ هەڵەیە تکایە دڵنیا ببەرەوە لێی');
        }
    }
}
