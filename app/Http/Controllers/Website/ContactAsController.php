<?php

namespace App\Http\Controllers\Website;

use App\ContactAsTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactAsController extends Controller
{
    public function index()
    {
        $contact = ContactAsTable::all()->first();
        return view('website.apps.contact',['contact'=>$contact]);
    }
    public function mail(Request $request)
    {
        $res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ldx190UAAAAANQojnYOiXXBpIVYJOIzRdW95gtA&response=".$request->input('g-recaptcha-response')."&remoteip".$_SERVER['REMOTE_ADDR']);
        $res = json_decode($res);
        if(!$res->success){
            return redirect()->back()->withErrors('من ڕۆبۆت نیم چێک بکە');
        }
        $data = $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|min:11',
            'email' => 'required|email|max:100',
            'content' => 'required|max:500|min:10',
        ],[
            'name.required' => 'تکایە ناوێک داغڵ بکە',
            'name.max' => 'تکایە ناتوانی لە ١٠٠ پیت زیاتر بنوسیت بۆ ناو',
            'phone.required' => 'تکایە ژ.مۆبایلێک داغڵ بکە',
            'phone.max' => 'تکایە ژ.مۆبایلێکی دروست داغڵ بکە',
            'email.required' => 'تکایە ئیمەیڵێک داغڵ بکە',
            'email.max' => 'تکایە ناتوانی لە ١٠٠ پیت زیاتر بنوسیت بۆ ئیمەیڵ',
            'email.email' => 'تکایە ئیمەیڵێکی دروست داغڵ بکە',
            'content.required' => 'تکایە ناوەڕۆکێك داغڵ بکە',
            'content.max' => 'تکایە ناتوانی لە ٥٠٠ پیت زیاتر بنوسیت بۆ ناوەڕۆک',
            'content.min' => 'تکایە ناتوانی لە ١٠ پیت کەمتر بنوسیت بۆ ناوەڕۆک',
        ]);
        $to_name = 'My Occasion';
        $to_email = 'koqkaq.qppp1@gmail.com';
        $d = [
            'name' => $request->input('name'),
            'body' => $request->input('content'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ];
        Mail::send('mail',$d,function ($massage) use ($to_email,$to_name)
        {
            $massage->to($to_email)->subject($to_name);
        });
        return redirect()->back()->withSuccess('سپاس بۆ پێشنیارەکەت');
    }
}
