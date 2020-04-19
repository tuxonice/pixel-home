@extends('adminlte::page')


@section('content')

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Sensor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('sensor.type.update', ['sensorType' => $sensorType->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" value="{{ $sensorType->name }}" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ route('sensor.type.list') }}" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Delete Sensor Type</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('sensor.type.delete', ['sensorType' => $sensorType->id]) }}">
                @method('DELETE')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <input type="checkbox" onchange='handleChange(this);'/>
                    <label>Yes, I want to delete this sensor type</label>
                    
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
