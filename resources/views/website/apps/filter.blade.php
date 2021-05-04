@extends('website.layout.app',['b_title'=>'گەڕان'])
@section('content')
<style>
    .card .horizontal,
        {
        padding: 10px 0px !important;
        max-height: 212px;
    }

    .card .card-content {
        padding: 0 !important;
    }

    .selected-custom-item {
        padding: 10px 0;
    }
</style>

<div class="container">

    <div class="row">
        <div class="col s12">
            <a class="waves-effect waves-light btn modal-trigger white-text pink filter-trigger"
                href="#modal1">فیلتەر</a>
        </div>
        <div class="col s12 m8 right" style="margin-top: -8px;">
            @forelse ($items as $item)
            <a href="{{route('item.show',['id'=>$item->ip_ID])}}" class="col s6 m4 right black-text" dir="rtl"
                style="padding:0">
                <div class="card center-align selected-custom-item" style="margin: 16px 8px 0;flex-direction: column">
                    <div class="card-image" style="background-image: url({{secure_asset('storage/'.$item->i_link)}});">
                        <img src="{{secure_asset('storage/'.$item->i_link)}}"
                            style="visibility: hidden;height: 150px;width:100%">
                    </div>
                    <div class="card-stacked ">
                        <div class="card-content" style="padding: 0;">
                            <p><b class="truncate">{{$item->ip_name}}</b></p>
                            <p class="truncate">{{number_format($item->ip_price)}} IQD</p>
                        </div>
                    </div>
                </div>
            </a>
            @empty

            @endforelse
            <br>
        </div>
        <form id="filter" action="{{route('search.search')}}" method="POST"
            class="col s12 m4 card filter-side custom-side">
            @csrf
            @method('POST')
            <div class="col s12 right-align">

                <ul dir="rtl" style="position: relative" class="collapsible expandable light-grey no-shadow">
                    <div class="collapsible-arrow"><i class="material-icons">keyboard_arrow_down</i></div>
                    <li>
                        <div class="collapsible-header light-grey">جۆر</div>
                        <div class="collapsible-body filter-collapse">
                            @foreach ($type as $filter)
                            <p>
                                <label>
                                    <input type="checkbox" name="type[]" value='{{$filter->tp_ID}}' />
                                    <span class="black-text">{{$filter->tp_name}}</span>
                                </label>
                            </p>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul dir="rtl" style="position: relative" class="collapsible expandable light-grey no-shadow">
                    <div class="collapsible-arrow"><i class="material-icons">keyboard_arrow_down</i></div>
                    <li>
                        <div class="collapsible-header light-grey">ڕەنگ</div>
                        <div class="collapsible-body filter-collapse">
                            @foreach ($color as $filter)
                            <p>
                                <label>
                                    <input type="checkbox" name="color[]" value='{{$filter->c_ID}}' />
                                    <span class="black-text">{{$filter->c_name}}</span>
                                </label>
                            </p>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul dir="rtl" style="position: relative" class="collapsible expandable light-grey no-shadow">
                    <div class="collapsible-arrow"><i class="material-icons">keyboard_arrow_down</i></div>
                    <li>
                        <div class="collapsible-header light-grey">بۆنە</div>
                        <div class="collapsible-body filter-collapse">
                            @foreach ($occasion as $filter)
                            <p>
                                <label>
                                    <input type="checkbox" name="occasion[]" value='{{$filter->oc_ID}}' />
                                    <span class="black-text">{{$filter->oc_name}}</span>
                                </label>
                            </p>
                            @endforeach
                        </div>
                    </li>
                </ul>


            </div>
            <div class="col s12 right-align">
                <p><button type="submit" class="btn-small small pink lighten-3 " style="width: 100%;">گەڕان</button></p>
            </div>
        </form>

    </div>

    <!-- Modal Structure -->
    <form action="{{route('search.search')}}" method="POST" id="modal1" class="modal bottom-sheet filter-modal">
        @csrf
        @method('POST')
        <div class="modal-content" style="overflow: hidden;">

            <ul dir="rtl" class="collapsible expandable light-grey no-shadow">
                <li>
                    <div class="collapsible-header light-grey" style="align-items: flex-start;">جۆر</div>
                    <div class="collapsible-body filter-collapse">
                        @foreach ($type as $filter)
                        <p>
                            <label>
                                <input type="checkbox" name="type[]" value='{{$filter->tp_ID}}' />
                                <span class="black-text">{{$filter->tp_name}}</span>
                            </label>
                        </p>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul dir="rtl" class="collapsible expandable no-shadow light-grey">
                <li>
                    <div class="collapsible-header light-grey" style="align-items: flex-start;">ڕەنگ</div>
                    <div class="collapsible-body filter-collapse">
                        @foreach ($color as $filter)
                        <p>
                            <label>
                                <input type="checkbox" name="color[]" value='{{$filter->c_ID}}' />
                                <span class="black-text">{{$filter->c_name}}</span>
                            </label>
                        </p>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul dir="rtl" class="collapsible expandable no-shadow light-grey">
                <li>
                    <div class="collapsible-header light-grey" style="align-items: flex-start;">بۆنە</div>
                    <div class="collapsible-body filter-collapse">
                        @foreach ($occasion as $filter)
                        <p>
                            <label>
                                <input type="checkbox" name="occasion[]" value='{{$filter->oc_ID}}' />
                                <span class="black-text">{{$filter->oc_name}}</span>
                            </label>
                        </p>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
        <div class="modal-footer bottom-sheet">
            <a onclick="submitForm(this)" class="modal-close waves-effect waves-green btn-flat">گەڕان</a>
        </div>
    </form>
</div>
<script>
    function submitForm(x){
    x.classList.add("disabled");
    var form = document.getElementById('modal1');
    form.submit();
}
</script>
@endsection