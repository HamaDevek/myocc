@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Orders Show</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.orders.index')}}">Orders</a></li>
        <li class="breadcrumb-item">{{$orders->oi_name_from}}</li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="border rounded p-4 col-lg-12">
                <h4><b>Order name </b>: {{$orders->oi_name_from}}</h4>
                <hr class="mt-4">
                <p><b>Order owner </b>: {{$orders->owner->a_name}}</p>
                <p><b>Order owner </b>: {{$orders->owner->a_phone}}</p>
                <p><b>Order Location </b>: {{$orders->location->l_name}}</p>
                <p><b>Recipient Phone </b>: {{$orders->oi_phone_from}}</p>
                <p><b>Recipient Address </b>: {{$orders->oi_address_from}}</p>
                @if ($orders->oi_type == 1)
                <p><b>Billed Name </b>: {{$orders->oi_name_to}}</p>
                <p><b>Billed Phone </b>: {{$orders->oi_phone_to}}</p>
                <p><b>Billed Address </b>: {{$orders->oi_address_to}}</p>
                <p><b>Type Order </b>: Other </p>
                @else
                <p><b>Type Order </b>: Myself </p>
                @endif
                <p><b>Delivery Date </b>: {{date('Y-m-d l',strtotime($orders->oi_to_date))}}</p>
                <p><b>Delivery Time </b>: {{date('h:i a',strtotime($orders->oi_to_time))}}</p>
                <p><b>State </b>: <span style="color: blue">Pendding</span></p>

            </div>
            <form id="taxi" method="POST" action="{{route('dashboard.orders.sendtaxi',['id'=>$orders->oi_ID])}}"
                class="p-3 col-lg-12">
                @csrf
                <div class="form-group">
                    <label for="usr">Taxi:</label>
                    <select name="taxi" class="custom-select mb-3">
                        @foreach ($taxi as $key => $value)
                        <option value="{{$value->t_ID}}">
                            {{$value->t_first_name}} {{$value->t_middle_name}} {{$value->t_last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex;justify-content: space-between">
                    <a onclick="submitForm(this)" class="btn btn-danger float-right text-light">Reject</a>
                    <input type="submit" class="btn btn-warning float-right" value="Delivery" />
                </div>
            </form>
            <form action="{{route('dashboard.orders.reject',['id'=>$orders->oi_ID])}}" id="form-sub" class="hidden"
                method="POST">
                @csrf
                @method('DELETE')
            </form>
        </div>

    </div>
    <div class="col-lg-8">
        <div class="row">
            <div class=" mt-3 col-lg-12">

                <h6 class="text-secondary ">Orders</h6>


                <hr>
                <div class="table-responsive">
                    <table class="table  table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>


                            @forelse ($orders->ordered->groupBy('o_group_by') as $key=>$itemS)

                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <tr data-toggle="collapse" data-target="#group-{{++$key}}"
                                        class="bg-secondary accordion-toggle">
                                        <td class="text-light">Group {{$key}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a type="submit"
                                                href="{{route('dashboard.orders.edit',['order'=>$orders->oi_ID,'group' => $itemS[0]->o_group_by])}}"
                                                class="btn btn-primary btn-sm float-right">Add item</a>
                                        </td>

                                    </tr>
                                    @foreach ($itemS as $item)

                                    <tr>

                                        <td>
                                            <img src="{{secure_asset('storage/'.$item->item->image[0]->i_link)}}"
                                                height="50px" width="50px" class="img-thumbnail" alt="...">
                                        </td>
                                        <td>{{$item->item->ip_name}}</td>
                                        <td>{{$item->item->ip_price}}</td>
                                        <td>{{$item->item->type->tp_name}}</td>
                                        <td>
                                            @if (!in_array($item->item->type->tp_ID,[6,7]))
                                            <form action="" id="form-sub-{{$key}}">
                                                <input
                                                    onchange="insert(this,'{{route('dashboard.orders.update',['order'=>$item->o_ID])}}')"
                                                    type="number" class="rounded" max="999" min="1"
                                                    style="max-width: 50px;outline: none;border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: groove;background-color: #eee;"
                                                    value="{{$item->o_amount}}">
                                            </form>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('dashboard.orders.destroy',['order'=> $item->o_ID])}}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger btn-sm float-right"
                                                    value="Delete" />
                                            </form>
                                        </td>

                                    </tr>

                                    @endforeach
                                    {{-- <tr>
                                        
                                        <td>
                                            <img src="{{secure_asset('storage/'.$item->item->image[0]->i_link)}}"
                                    height="50px" width="50px" class="img-thumbnail" alt="...">
                                    </td>
                                    <td>{{$item->item->ip_name}}</td>
                                    <td>{{$item->item->ip_price}}</td>
                                    <td>{{$item->item->type->tp_name}}</td>
                                    <td>
                                        <form action="" id="form-sub-{{$key}}">
                                            <input
                                                onchange="insert(this,'{{route('dashboard.orders.update',['order'=>$item->o_ID])}}')"
                                                type="number" class="rounded" max="999" min="1"
                                                style="max-width: 50px;outline: none;border-top-style: hidden;border-right-style: hidden;border-left-style: hidden;border-bottom-style: groove;background-color: #eee;"
                                                value="{{$item->o_amount}}">
                                        </form>
                                        @php
                                        $price_all = $price_all + $item->item->ip_price;
                                        $amount_all = $amount_all + $item->o_amount;
                                        @endphp
                                    </td>
                                    <td>
                                        <form action="{{route('dashboard.orders.destroy',['order'=> $item->o_ID])}}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger btn-sm float-right"
                                                value="Delete" />
                                        </form>
                                    </td>

                                    </tr> --}}
                                </div>
                            </div>
                            @empty

                            @endforelse
                            {{-- <tr data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
                                <td>1</td>
                                <td>05 May 2013</td>
                                <td>Credit Account</td>
                                <td class="text-success">$150.00</td>
                                <td class="text-error"></td>
                                <td class="text-success">$150.00</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo1"> Demo1 </div>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function submitForm(x) {
        x.classList.add("disabled");
        var form = document.getElementById('form-sub');
        form.submit();
    }
    function insert(inputs,link) {
        
        $.ajax({
        method: "PUT",
        url: link,
        data: {
        "_token": "{{ csrf_token() }}",
        "amount" : inputs.value
        },
        success:function (msg) {
            alert(msg);
            location.reload();
             
        },
        error:function (jqXHR, textStatus, errorThrown) {
            
               alert('Data Not Updated !!!'); 
            
        },
        });
    }
</script>
@endsection

{{-- .done(function( msg ) {
            
        if(msg.error == 0){
            alert(msg);
        }else{
            alert(msg);
        }
        alert(msg);
    } --}}