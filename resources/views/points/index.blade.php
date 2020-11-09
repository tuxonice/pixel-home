@extends('adminlte::page')


@section('content')

<div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Search</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="GET">
                <div class="card-body">
                  <div class="form-group">
                    <label for="sensor">Device</label>
                    <select class="form-control" id="device" name="device">
                    <option value=""> --All devices-- </option>
                      @foreach($devices as $device)
                        @if($selectedDevice == $device->id) {
                          <option value="{{ $device->id }}" selected="selected"> {{ $device->name }} </option>
                        } @else {
                          <option value="{{ $device->id }}"> {{ $device->name }} </option>
                        }
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="sensor">Sensor</label>
                    <select class="form-control" id="sensor" name="sensor">
                        <option value=""> --Select-- </option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Points</h3>
                    <div class="card-tools">
                        {{ $dataPoints->appends(['device' => $selectedDevice])->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Device</th>
                            <th>Location</th>
                            <th>Sensor</th>
                            <th>Value</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataPoints as $dataPoint)
                            <tr>
                                <th scope="row">{{ $dataPoint->id }}</th>
                                <td>{{ $dataPoint->device()->first()->name }}</td>
                                <td>{{ $dataPoint->device()->first()->location }}</td>
                                <td>{{ $dataPoint->sensor()->first()->name }}</td>
                                <td>{{ $dataPoint->value }} {{ $dataPoint->sensor()->first()->unit_symbol }}</td>
                                <td>{{ $dataPoint->added_on }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                  
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

@stop
@section('js')
<script>
  $(function () {
    
    $("#device").on('change',function(){
      var deviceId = $("#device").val();
      $.get("/data-points/getSensor?device-id=" + deviceId, function(data, status){
      console.log(data);
      });
    });      
  });
   
</script>
@stop
