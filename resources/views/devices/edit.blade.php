@extends('adminlte::page')


@section('content')

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Device</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('device.update', ['device' => $device->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Device Name" value="{{ $device->name }}" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Device Location" value="{{ $device->location }}" required>
                  </div>
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code" value="{{ $device->code }}" placeholder="Device Code" required>
                  </div>
                  <div class="form-group">
                    <label for="sensor">Add new Sensor</label>
                    <select class="form-control" name="sensor_id">
                    <option value="0">-- Select --</option>
                    @foreach($sensors as $sensor)
                    <option value="{{$sensor->id}}">{{$sensor->name}} ({{$sensor->unit_symbol}})</option>
                    @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="active" id="active" value="1" {{ $device->active ? 'checked="checked"' : '' }}/>
                    <label>Active</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ route('device.list') }}" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensors</h3>
                </div>
                <!-- /.card-header -->
                <form role="form" method="POST" action="{{ route('device.delete.sensor', ['device' => $device->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-body p-0">
                    @if($device->sensors()->count() == 0)
                    <div class="text-center p-2">No sensors</div>
                    @else
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Active</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($device->sensors()->get() as $sensor)
                            <tr>
                                <th scope="row">{{ $sensor->id }}</th>
                                <td>{{ $sensor->name }}</td>
                                <td>{{ $sensor->unit }} ({{ $sensor->unit_symbol }})</td>
                                <td>{{ $sensor->active }}</td>
                                <td><button type="submit" name="sensor_id" value="{{ $sensor->id }}" class="btn btn-danger">Remove Sensor</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="card-footer">
                </div>
                </form>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Delete Device</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('device.delete', ['device' => $device->id]) }}">
                @method('DELETE')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <input type="checkbox" onchange='handleChange(this);'/>
                    <label>Yes, I want to delete this device</label>
                    
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-danger" id="delete-sensor" disabled="disabled">Delete</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>



@stop
@section('js')
<script>
  function handleChange(checkbox) {
    if(checkbox.checked === true){
        document.getElementById("delete-sensor").removeAttribute("disabled");
        return;
    }
    
    document.getElementById("delete-sensor").setAttribute("disabled", "disabled");
   }
   
</script>
@stop
