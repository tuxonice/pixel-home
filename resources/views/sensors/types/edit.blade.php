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
              <form role="form" method="POST" action="{{ route('sensor.update', ['sensor' => $sensor->id]) }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" onKeyUp='updateEndpoint(this);' id="code" value="{{ $sensor->code }}" placeholder="Sensor Code" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" value="{{ $sensor->name }}" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Sensor Location" value="{{ $sensor->location }}" required>
                  </div>
                  <div class="form-group">
                    <label for="type">Sensor Type</label>
                    <select class="form-control" name="type">
                      <option value="HT" {{ $sensor->type === 'HT' ? 'selected' : '' }}>HT</option>
                      <option value="FLOOD" {{ $sensor->type === 'FLOOD' ? 'selected' : '' }}>FLOOD</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hash">Hash</label>
                    <input type="text" class="form-control" name="hash" onKeyUp='updateEndpoint(this);' id="hash" value="{{ $sensor->hash }}" required>
                  </div>
                  <div class="form-group">
                    <label for="endpoint">Push Endpoint</label>
                    <input type="text" class="form-control" id="endpoint" value="{{ $pushEndPoint }}" readonly="readonly">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ route('sensor.list') }}" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Delete Sensor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('sensor.delete', ['sensor' => $sensor->id]) }}">
                @method('DELETE')
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <input type="checkbox" onchange='handleChange(this);'/>
                    <label>Yes, I want to delete this sensor</label>
                    
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
   
   function updateEndpoint() {
     
     let codeElem = document.getElementById("code");
     let hashElem = document.getElementById("hash");
     
     let endPoint = '{{ request()->getSchemeAndHttpHost() }}/event/push/' + hashElem.value + '?sensor=' + codeElem.value
     
     document.getElementById("endpoint").value = endPoint;
     
     
     
     
   }
   
</script>
@stop
