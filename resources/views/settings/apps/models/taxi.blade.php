<!-- Schedule -->
<div id="schedule_add" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Schedule</h4>
            </div>
            <div class="row">
                <div class="col-lg-11 mx-auto">
                    <form id="cc" action="{{route('dashboard.taxi.schedule_add', $edit->t_ID)}}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="form-group mt-3">
                            <select name="week" class="custom-select ">
                                @forelse ($days as $day)
                                <option value="{{$day->w_ID}}">
                                    {{$day->w_days}}
                                </option>
                                @empty
                                <script>
                                    document.getElementById('cc').remove();
                                </script>
                                @endforelse
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <input type="time" class="form-control" name="from" id="from" placeholder="From">
                        </div>
                        <div class="form-group">
                            <input type="time" class="form-control" name="to" id="to" placeholder="To">
                        </div>
                        <input type="submit" class="btn btn-success mb-3 float-right" value="add Day">
                    </form>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Week Day</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($edit->schedule as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$item->schedule->w_days}}</td>
                                    <td>{{date('H:i',strtotime($item->from))}}</td>
                                    <td>{{date('H:i',strtotime($item->to))}}</td>
                                    <td>
                                        <form action="{{route('dashboard.taxi.schedule_delete',$item->ts_ID)}}" method="POST">
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