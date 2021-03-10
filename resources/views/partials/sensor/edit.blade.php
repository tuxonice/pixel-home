<x-app-layout>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sensors</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sensors</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class="content">
<div class="container-fluid">


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
                    <label for="code">Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $sensor->name }}" placeholder="Sensor Code" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Unit</label>
                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" value="{{ $sensor->unit }}" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Unit Symbol</label>
                    <input type="text" class="form-control" name="unit_symbol" id="unit_symbol" placeholder="Symbol" value="{{ $sensor->unit_symbol }}" required>
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="active" id="active" value="1" {{ $sensor->active ? 'checked="checked"' : '' }}/>
                    <label>Active</label>
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

</div>
</div>
</div>

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
<!-- /.content-wrapper -->
</x-app-layout>