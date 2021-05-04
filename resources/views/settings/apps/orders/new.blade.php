@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Orders Add Item</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.orders.index')}}">Orders</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-12">
        <form action="{{route('dashboard.orders.search',['order'=>$order,'group'=>$group])}}" method="POST">
            @csrf
            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button"
                    aria-expanded="false" aria-controls="multiCollapseExample1">Type</a>
                @isset($occasion)
                @if (count($occasion) > 0)
                <button class="btn btn-primary" type="button" data-toggle="collapse"
                    data-target="#multiCollapseExample2" aria-expanded="false"
                    aria-controls="multiCollapseExample2">Occasion</button>
                @endif
                @endisset
                @if (count($color) > 0)
                <button class="btn btn-primary" type="button" data-toggle="collapse"
                    data-target="#multiCollapseExample3" aria-expanded="false"
                    aria-controls="multiCollapseExample3">Color</button>
                @endif

            </p>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            @foreach ($type as $value)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="type[]" value="{{$value->tp_ID}}">
                                <label class="form-check-label">
                                    {{$value->tp_name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @isset($occasion)
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            @foreach ($occasion as $value)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="occasion[]"
                                    value="{{$value->oc_ID}}">
                                <label class="form-check-label">
                                    {{$value->oc_name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endisset
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample3">
                        <div class="card card-body">
                            @foreach ($color as $value)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="color[]" value="{{$value->c_ID}}">
                                <label class="form-check-label">
                                    {{$value->c_name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-warning mt-3" value="Search">
        </form>
    </div>
    <div class="col-lg-12">
        <h6 class="text-secondary ">Items</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Occasion</th>
                        <th>Type</th>
                        <th>Add item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key => $value)
                    <tr>
                        <td>
                            <img src="{{secure_asset('storage/'.$value->i_link)}}" height="50px" width="50px"
                                class="img-thumbnail" alt="...">
                        </td>
                        <td>
                            {{$value->ip_name}}
                        </td>
                        <td>
                            {{$value->ip_price}}
                        </td>
                        <td>
                            {!!App\Helpers\Common::limit($value->ip_description,50)!!}
                        </td>
                        <td>
                            {{$value->oc_name}}
                        </td>
                        <td>
                            {{$value->tp_name}}
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#exampleModalCenter{{++$key}}">
                                add
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter{{$key}}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle"> {{$value->ip_name}}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row" id="form-sub-{{$key}}"
                                                action="{{route('dashboard.orders.store')}}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="item" value="{{$value->ip_ID}}">
                                                <input type="hidden" name="group" value="{{$group}}">
                                                <input type="hidden" name="order" value="{{$order}}">
                                                <div class="col-lg-2">
                                                    <img src="{{secure_asset('storage/'.$value->i_link)}}" height="50px"
                                                        width="50px" class="img-thumbnail" alt="...">
                                                </div>
                                                <div class="col-lg-10">
                                                    <center>
                                                        <div class="input-group">

                                                            <input name="amount" class="form-control"
                                                                aria-label="Sizing example input"
                                                                aria-describedby="inputGroup-sizing-sm" type="number"
                                                                max="999" min="1" value="1">
                                                        </div>
                                                    </center>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" onclick="subForm(this,'form-sub-{{$key}}')"
                                                class="btn btn-primary">Add
                                                Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function subForm(x,forms) {
        x.classList.add("disabled");
        var form = document.getElementById(forms);
        form.submit();
    }
</script>
@endsection