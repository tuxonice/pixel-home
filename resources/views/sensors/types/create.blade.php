@extends('adminlte::page')


@section('content')

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Sensor Type</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="POST" action="{{ route('sensor.type.save') }}">
                @csrf  
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Type Name" required>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                  <a href="{{ route('sensor.type.list') }}" class="btn btn-default">Cancel</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>


@stop
