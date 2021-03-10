<x-app-layout>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">New Devices</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Devices</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class="col-md-12">
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
        <h3 class="card-title">New Device</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('device.save') }}">
        @csrf  
        <div class="card-body">
            <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" required>
            </div>
            <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" name="location" id="location" placeholder="Sensor Location" required> 
            </div>
            <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" name="code" id="code" placeholder="Sensor Code" value="{{ $code }}" required>
            </div>
            <div class="form-group">
            <label for="sensor">Add new Sensor</label>
            <select class="form-control" name="sensor_id">
            <option option="0">-- Select --</option>
            @foreach($sensors as $sensor)
            <option value="{{$sensor->id}}">{{$sensor->name}} ({{$sensor->unit_symbol}})</option>
            @endforeach
            </select>
            </div>
            <div class="form-group">
            <input type="checkbox" name="active" id="active" value="1" checked="checked"/>
            <label>Active</label>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('device.list') }}" class="btn btn-default">Cancel</a>
        </div>
        </form>
    </div>
    <!-- /.card -->
</div>

</div>

</x-app-layout>