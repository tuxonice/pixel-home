@extends('adminlte::page')


@section('content')

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Sensor</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST">
				@csrf  
                <div class="card-body">
                  <div class="form-group">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" name="code" id="code" placeholder="Sensor Code" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="Sensor Location" required> 
                  </div>
                  <div class="form-group">
                    <label for="type">Sensor Type</label>
                    <select class="form-control" name="type">
						<option value="HT">HT</option>
						<option value="FLOOD">FLOOD</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="hash">Hash</label>
                    <input type="text" class="form-control" name="hash" id="hash" value="{{ $hash }}" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <a href="{{ route('sensor.list') }}" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>


@stop
