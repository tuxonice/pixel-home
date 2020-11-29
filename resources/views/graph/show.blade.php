@extends('adminlte::page')


@section('plugins.Chartjs', true)

@section('content')

    <section class="content">
        
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
                    <select class="form-control" id="device-id" name="device-id">
                        <option value="0"> Select a device </option>
                        @foreach($devices as $device)
                          <option value="{{$device->id}}" {{ $selectedDeviceId == $device->id ? 'selected="selected"' : '' }}>{{$device->name}}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="sensor">Sensor</label>
                    <select class="form-control" id="sensor-id" name="sensor-id">
                        <option value=""> Select a sensor </option>
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
                  
                  <div class="form-group">
                  <label>Date range:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control float-right" id="range-date" value="{{ $startDate }} - {{ $endDate }}">
                    <input type="hidden" name="start-date" id="start-date" value="{{ $startDate }}">
                    <input type="hidden" name="end-date" id="end-date" value="{{ $endDate }}">
                  </div>
                  <!-- /.input group -->
                </div>
                
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="time-distribution" value="linear" {{ $timeDistribution === 'linear' ? 'checked="checked"' : '' }}/> Linear Time Distribution
                  </label>
                </div>
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>
        
        
        
        <div class="row">
            <div class="col-md-12">
                <!-- LINE CHART -->
                
                  <div class="box box-info">
                      @if($selectedDevice && $selectedSensor)
                      <div class="box-header with-border">
                          <h3 class="box-title">
                            {{ $selectedDevice->name }}
                          </h3>
                      </div>
                      <div class="box-body">
                          <div class="chart">
                              <canvas id="deviceChart" height="100" width="500"></canvas>
                          </div>
                      </div><!-- /.box-body -->
                      @endif
                  </div><!-- /.box -->
                
            </div><!-- /.col (RIGHT) -->
        </div><!-- /.row -->

    </section><!-- /.content -->


@stop

@section('css')
    <link rel="stylesheet" href="/css/daterangepicker.css">
@stop

@section('js')
<script src="/js/moment.min.js"></script>
<script src="/js/daterangepicker.js"></script>

    <script>
      $(function () {
    
    $("#device-id").on('change',function(){
      var deviceId = $("#device-id").val();
      if(deviceId) {
        $.get("/data-points/getSensor?device-id=" + deviceId, function(data, status){
        $('#sensor-id').empty().append('<option value="0">-- Select a sensor --</option>');
        $.each(data, function (i, item) {
          $('#sensor-id').append($('<option>', { 
            value: item.id,
            text : item.name 
          }));
        });
      });
      }
    });     
  });

  @if($selectedDevice && $selectedSensor)
        $(function () {
            $('#range-date').daterangepicker({
                startDate: '{{ $startDate }}',
                endDate: '{{ $endDate }}',
                locale: {
                    format: 'YYYY-MM-DD kk:mm'
                },
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 30
        }, function(start, end, label) {
            $("#start-date").val(start.format('YYYY-MM-DD kk:mm:ss'));
            $("#end-date").val(end.format('YYYY-MM-DD kk:mm:ss'));
            });
            
            
            let deviceChartElem = document.getElementById('deviceChart').getContext('2d');
            
            let deviceChart = new Chart(deviceChartElem, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    datasets: [
                      {
                        label: '@if($selectedSensor) {{ $selectedSensor->name }} ({{ $selectedSensor->unit_symbol }}) @endif',
                        borderColor: "rgb(0,0,255)",
                        data: [
                            @foreach($points as $point)
                            {
                                x: '{{$point->added_on}}',
                                y: '{{$point->value}}'
                            },
                            @endforeach
                        ]
                      },
                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [
                            {
                                type: 'time',
                                distribution: '{{ $timeDistribution }}',
                                time: {
                                    unit: 'day'
                                }
                            }
                        ]
                    }
                }
            });
            
      });
      @endif
    </script>
@stop
