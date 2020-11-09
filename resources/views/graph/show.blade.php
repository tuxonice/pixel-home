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
                        <option value="0"> All Devices </option>
                        @foreach($devices as $device)
                          <option value="{{$device->id}}" {{ $selectedDeviceId == $device->id ? 'selected="selected"' : '' }}>{{$device->name}}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="sensor">Sensor</label>
                    <select class="form-control" id="sensor-id" name="sensor-id">
                        <option value=""> All sensors </option>
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Temperature</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="temperatureChart" height="100" width="500"></canvas>
                        </div>
                    </div><!-- /.box-body -->
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
            $('#range-date').daterangepicker({
                startDate: '{{ $startDate }}',
                endDate: '{{ $endDate }}',
                locale: {
                    format: 'YYYY-MM-DD'
                }
        }, function(start, end, label) {
            $("#start-date").val(start.format('YYYY-MM-DD'));
            $("#end-date").val(end.format('YYYY-MM-DD'));
            });
            
            
            let temperatureChartElem = document.getElementById('temperatureChart').getContext('2d');
            
            let temperatureChart = new Chart(temperatureChartElem, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    datasets: [
                      {
                        label: 'Temperature',
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
    </script>
@stop
