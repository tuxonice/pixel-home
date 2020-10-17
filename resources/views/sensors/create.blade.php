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
              <form role="form" method="POST" action="{{ route('sensor.save') }}">
                @csrf  
                <div class="card-body">
                  <div class="form-group">
                    <label for="code">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Sensor Name" required>
                  </div>
                  <div class="form-group">
                    <label for="name">Unit</label>
                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Sensor Unit" required>
                  </div>
                  <div class="form-group">
                    <label for="location">Unit Symbol</label>
                    <input type="text" class="form-control" name="unit_symbol" id="unit_symbol" placeholder="Symbol" required> 
                  </div>
                  <div class="form-group">
                    <input type="checkbox" name="active" id="active" value="1" checked="checked"/>
                    <label>Active</label>
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
