@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Colors</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.color.index')}}">Colors</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <!-- Form -->
    @if (isset($edit))

    <div class="col-lg-6">
        <form action="{{route('dashboard.color.update',["id"=>$edit->c_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name : {{$edit->c_name}}</label>
                <div class="row">
                    <div class="col-lg-11"><input type="text" value="{{$edit->c_name}}" class="form-control" name="name"
                            id="name" placeholder="Name"></div>
                    <div class="col-lg-1">
                        <div class="color-picker"></div>
                    </div>
                    <input type="hidden" name="color" value="{{$edit->c_color}}" id="changable">
                </div>

            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit Color" />
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.color.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Name:</label>
                <div class="row">
                    <div class="col-lg-11"><input type="text" class="form-control" name="name" id="name"
                            placeholder="Name"></div>
                    <div class="col-lg-1">
                        <div class="color-picker"></div>
                    </div>

                </div>
            </div>
            <input type="hidden" name="color" value="#ff80ab" id="changable">

            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Color" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Colors</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($color as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->c_ID}}</td>
                        <td>{{$item->c_name}}</td>
                        <td>
                            <div style="height:40px;width:40px;background-color:{{$item->c_color}} !important"></div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark  btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                    Options
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                        href="{{route('dashboard.color.edit',$item->c_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.color.destroy',$item->c_ID)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger dropdown-item" value="Delete" />
                                    </form>

                                </div>
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script>
        const pickr = Pickr.create({
        el: '.color-picker',
        theme: 'classic', // or 'monolith', or 'nano'
        default: '{{empty($edit->c_color) ? "#ff80ab" : $edit->c_color}}' ,
        swatches: [
            'rgba(244, 67, 54, 1)',
            'rgba(233, 30, 99, 0.95)',
            'rgba(156, 39, 176, 0.9)',
            'rgba(103, 58, 183, 0.85)',
            'rgba(63, 81, 181, 0.8)',
            'rgba(33, 150, 243, 0.75)',
            'rgba(3, 169, 244, 0.7)',
            'rgba(0, 188, 212, 0.7)',
            'rgba(0, 150, 136, 0.75)',
            'rgba(76, 175, 80, 0.8)',
            'rgba(139, 195, 74, 0.85)',
            'rgba(205, 220, 57, 0.9)',
            'rgba(255, 235, 59, 0.95)',
            'rgba(255, 193, 7, 1)'
        ],
        autoReposition: true,
        components: {
            // Main components
            preview: true,
            opacity: true,
            hue: true,
    
            // Input / output Options
            interaction: {
                hex: true,
                rgba: false,
                hsla: false,
                hsva: false,
                cmyk: false,
                input: false,
                clear: true,
                save: true
            }
        }
    });
    
        pickr.on('save', (color, instance) => {
            document.getElementById('changable').value = color.toHEXA().toString(3);
        });
    
    </script>
    @endsection