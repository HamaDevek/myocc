<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\QandA;
use Illuminate\Http\Request;

class QandAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qa = QandA::orderBy('created_at','DESC')->get();
        
        return view('settings.apps.qanda',['qanda'=>$qa]);
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
            'question' => 'required|min:10',
            'answer' => 'required|min:10',
        ]);
        $qa = new QandA();
        $qa->qa_q = $request->question;
        $qa->qa_a = $request->answer;
        $qa->qa_state = 0;
        $qa->save();
        return redirect()->back()->withSuccess('Added Q&A Successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qa = QandA::orderBy('created_at','DESC')->get();
        $qanda = QandA::findOrFail($id);
        return view('settings.apps.qanda',['qanda'=>$qa,'edit' => $qanda]);
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
        if($type == 1){
            $q = QandA::findOrFail($id);
            $q->qa_state = !$q->qa_state;
            $q->save();
            return redirect()->back()->withSuccess('Done');
        }else{
            $data = $request->validate([
                'question' => 'required|min:10',
                'answer' => 'required|min:10',
            ]);
            $q = QandA::findOrFail($id);
            $q->qa_q = $request->question;
            $q->qa_a = $request->answer;
            $q->qa_state = isset($request->state) ? 1 : 0;
            $q->save();
            return redirect()->back()->withSuccess('Done');
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
       
        QandA::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Delete Q&A Successfuly');
    }
}
