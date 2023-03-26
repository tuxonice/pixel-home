<x-app-layout>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Points</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Data Points</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
      <div class="container-fluid">
<!-- search -->
<div class="row">
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
                        @if($selectedDevice && $selectedDevice->id == $device->id) {
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
                        @if($selectedDevice) {
                          @foreach($selectedDevice->sensors as $sensor)
                            @if($selectedSensorId == $sensor->id)
                            <option value="{{ $sensor->id }}" selected="selected"> {{ $sensor->name }} </option>
                            @else
                            <option value="{{ $sensor->id }}"> {{ $sensor->name }} </option>
                            @endif
                          @endforeach
                        @endif
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                  @if($graphUrl)
                  <a href="{{ $graphUrl }}" class="ml-2 btn bg-olive">
                    <i class="fa fa-bell"></i> Graph
                  </a>
                  @endif
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>
</div>
<!-- /search -->

<!-- list -->

<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Points</h3>
                    <div class="card-tools">
                        {{ $dataPoints->appends(['device' => $selectedDeviceId, 'sensor' => $selectedSensorId])->links('pagination.bootstrap-4') }}
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
                                <td>{{ $dataPoint->added_on->setTimezone($userTimeZone) }}</td>
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

<!-- /list -->

</div>
</div>
</div>
@section('js')
<script>
  $(function () {

    $("#device").on('change',function(){
      var deviceId = $("#device").val();
      if(deviceId) {
        $.get("/data-points/getSensor?device-id=" + deviceId, function(data, status){
        $('#sensor').empty().append('<option value="">-- All Sensors --</option>');
        $.each(data, function (i, item) {
          $('#sensor').append($('<option>', {
            value: item.id,
            text : item.name
          }));
        });
      });
      }
    });
  });

</script>
@stop
<!-- /.content-wrapper -->
</x-app-layout>
