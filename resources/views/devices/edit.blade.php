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
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Type</th>
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
                                <td>{{ $sensor->sensorType()->first()->name }}</td>
                                <td>{{ $sensor->active }}</td>
                                <td><a href="{{ url("/sensor/{$sensor->id}/edit") }}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                        
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-sensor">
  Add new Sensor
</button>
                </div>
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

<div class="modal fade" id="new-sensor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Sensor</h4>
      </div>
      <div class="modal-body">
      <form role="form" method="POST" action="{{ route('sensor.save', ['device' => $device->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" required>
                  </div>
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="unit_symbol" id="unit_symbol" placeholder="Unit Symbol" required>
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="active" id="active" value="1"/>
                    <label>Active</label>
                  </div>
                </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
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
