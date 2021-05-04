<!-- Color -->
<div id="cols" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Colors</h4>

            </div>
            <div class="row">
                <div class="col-lg-11 mx-auto">

                    <form id="cc" action="{{route('dashboard.item.color', $edit->ip_ID)}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group mt-3">
                            <select name="cols" class="custom-select mb-3 ">
                                @forelse ($colors as $col)
                                <option value="{{$col->c_ID}}">
                                    {{$col->c_name}}
                                </option>
                                @empty
                                <script>
                                    document.getElementById('cc').remove();
                                </script>
                                @endforelse
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success mb-3 float-right" value="add color">
                    </form>


                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($edit->colors as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->color->c_name}}</td>
                                    <td>
                                        <div
                                            style="height:40px;width:40px;background-color:{{$item->color->c_color}} !important">
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{route('dashboard.item.color_delete',$item->ic_ID)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger " value="Delete" />
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mb-5"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Image -->
<div id="image" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Image</h4>
            </div>
            <div class="row">
                <div class="col-lg-11 mx-auto">
                    <form action="{{route('dashboard.item.image', $edit->ip_ID)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="mt-3 form-group">
                            <input name="imgs" type="file" class="form-control-file" id="exampleFormControlFile1">
                        </div>
                        <input type="submit" class="btn btn-success mb-3 float-right" value="add Image">
                    </form>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Delete</th>
                                    <th>Set Primary</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($edit->image as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->i_ID}}</td>
                                    <td>
                                        <div style="height:40px;width:40px">
                                            <a href="{{secure_asset('storage/'.$item->i_link)}}"><img
                                                    src="{{secure_asset('storage/'.$item->i_link)}}"
                                                    class="img-thumbnail" alt=""></a>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{route('dashboard.item.image_delete',$item->i_ID)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger " value="Delete" />
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{route('dashboard.item.image_update',$item->i_ID)}}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                {!! $item->i_is_primary == 1 ? '': '<input type="submit" class="btn btn-sm btn-primary" value="Enable" />' !!}
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
