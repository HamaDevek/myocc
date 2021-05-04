@extends('website.layout.app',[
'b_title' => 'پرسیارە باوەکان'
])
@section('content')
<div class="container">
    <div class="row">
        <br>
        <div class="col s12">
            <ul dir="rtl" class="collapsible expandable">
                @foreach ($qa as $item)
                <li>
                    <div class="collapsible-header">{{$item->qa_q}}</div>
                    <div class="collapsible-body"><span>{!!$item->qa_a!!}</span></div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection