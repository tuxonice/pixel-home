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
                    <label for="sensor">Sensor</label>
                    <input type="text" class="form-control" id="sensor" name="sensor" placeholder="Sensor name" value="{{ $sensor }}">
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
        
        
        
        <div class="row">
            <div class="col-md-12">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Line Chart</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" height="100" width="500"></canvas>
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
            
            
            let ctx = document.getElementById('lineChart').getContext('2d');
            let chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    datasets: [
                    @foreach($events as $key => $value)
                      {
                        label: '{{$key}}',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [
                            @foreach($value as $data)
                            {
                                x: '{{$data->added_on}}',
                                y: '{{$data->temperature}}'
                            },
                            @endforeach
                        ]
                      },
                    @endforeach
                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [
                            {
                                type: 'time',
                                distribution: 'series',
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
