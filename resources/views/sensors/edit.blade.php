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
              <form role="form" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code" value="{{ $sensor->code }}" placeholder="Sensor Code">
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" value="{{ $sensor->name }}">
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Sensor Location" value="{{ $sensor->location }}">
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
                    <input type="text" class="form-control" name="hash" id="hash" value="{{ $sensor->hash }}">
                  </div>
                  <div class="form-group">
                    <label for="endpoint">Push Endpoint</label>
                    <input type="text" class="form-control" value="{{ $pushEndPoint }}" readonly="readonly">
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
                    <input type="checkbox" />
                    <label>Yes, I want to delete this sensor</label>
                    
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-danger">Delete</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

@stop
