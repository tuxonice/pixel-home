<x-app-layout>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Graph</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Graph</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="content">
        <div class="container-fluid">

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
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
</div>

@if($selectedDevice && $selectedSensor)
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-arrow-alt-circle-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Max</span>
                <span class="info-box-number">
                {{ $maxValue }}
                  <small>{{ $selectedSensor->unit_symbol }}</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-arrow-alt-circle-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Min</span>
                <span class="info-box-number">{{ $minValue }}
                <small>{{ $selectedSensor->unit_symbol }}</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-line"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Average</span>
                <span class="info-box-number">{{ $averageValue }}
                <small>{{ $selectedSensor->unit_symbol }}</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
@endif

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
                                <div id="deviceChart"></div>
                            </div>
                        </div><!-- /.box-body -->
                      @else
                        <p class="text-center mt-5 font-weight-bold">No data to show</p>
                      @endif
                  </div><!-- /.box -->
            </div><!-- /.col (RIGHT) -->
        </div><!-- /.row -->

    </section><!-- /.content -->


        </div><!-- container-fluid -->
    </div><!-- /.content -->

</div> <!-- content-wrapper -->
@section('css')
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
    <style>
        #deviceChart {
            width: 100%;
            height: 500px;
            max-width: 100%
        }
    </style>
@stop

@section('js')
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>


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


        $(function () {
            $('#range-date').daterangepicker({
                startDate: '{{ $startDate }}',
                endDate: '{{ $endDate }}',
                locale: {
                    format: 'YYYY-MM-DD HH:mm'
                },
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 30
        }, function(start, end, label) {
            $("#start-date").val(start.format('YYYY-MM-DD HH:mm:ss'));
            $("#end-date").val(end.format('YYYY-MM-DD HH:mm:ss'));
            });



      });

      am5.ready(function() {

          // Create root element
          // https://www.amcharts.com/docs/v5/getting-started/#Root_element
          var root = am5.Root.new("deviceChart");


          // Set themes
          // https://www.amcharts.com/docs/v5/concepts/themes/
          root.setThemes([
              am5themes_Animated.new(root)
          ]);


          // Create chart
          // https://www.amcharts.com/docs/v5/charts/xy-chart/
          var chart = root.container.children.push(am5xy.XYChart.new(root, {
              panX: true,
              panY: true,
              wheelX: "panX",
              wheelY: "zoomX",
              pinchZoomX:true
          }));


          // Add cursor
          // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
          var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
              behavior: "none"
          }));
          cursor.lineY.set("visible", false);

          function generateDatas() {
              return JSON.parse({!! $points !!});
          }


          // Create axes
          // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
          var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
              //maxDeviation: 0.2,
              baseInterval: {
                  timeUnit: "minute",
                  count: 1
              },
              renderer: am5xy.AxisRendererX.new(root, {}),
              tooltip: am5.Tooltip.new(root, {})
          }));

          var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
              renderer: am5xy.AxisRendererY.new(root, {})
          }));


          // Add series
          // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
          var series = chart.series.push(am5xy.LineSeries.new(root, {
              name: "Series",
              xAxis: xAxis,
              yAxis: yAxis,
              valueYField: "value",
              valueXField: "date",
              tooltip: am5.Tooltip.new(root, {
                  labelText: "{valueY}"
              })
          }));

          series.data.processor = am5.DataProcessor.new(root, {
              numericFields: ["value"],
              dateFields: ["date"],
              dateFormat: "yyyy-MM-dd H:m:s"
          });


          // Add scrollbar
          // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
          chart.set("scrollbarX", am5.Scrollbar.new(root, {
              orientation: "horizontal"
          }));

          series.fills.template.setAll({
              fillOpacity: 0.2,
              visible: true
          });

          series.strokes.template.setAll({
              strokeWidth: 2
          });

          series.bullets.push(function() {
              var circle = am5.Circle.new(root, {
                  radius: 2,
                  fill: root.interfaceColors.get("background"),
                  stroke: series.get("fill"),
                  strokeWidth: 2
              })

              return am5.Bullet.new(root, {
                  sprite: circle
              })
          });

          // Set data
          var data = generateDatas();
          console.log(data);
          series.data.setAll(data);


          // Make stuff animate on load
          // https://www.amcharts.com/docs/v5/concepts/animations/
          series.appear(100);
          chart.appear(100, 100);

      }); // end am5.ready()
    </script>
@stop
<!-- /.content-wrapper -->
</x-app-layout>
