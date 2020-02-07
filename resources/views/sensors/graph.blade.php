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
                    <input type="text" class="form-control" id="sensor" name="sensor" placeholder="Sensor name" value="">
                  </div>
                  
                  <div class="form-group">
                  <label>Date and time range:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control float-right" name="reservationtime" id="reservationtime">
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
            $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    });
            
            
            let ctx = document.getElementById('lineChart').getContext('2d');
            let chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    datasets: [
                      {
                        label: 'HT01',
                        borderColor: 'rgb(255, 99, 132)',
                        data: {!! $ht01 !!}
                      },
                      {
                        label: 'FL01',
                        borderColor: 'rgb(255, 132, 99)',
                        data: {!! $fl01 !!}
                      },
                      {
                        label: 'FL02',
                        borderColor: 'rgb(99, 255, 132)',
                        data: {!! $fl02 !!}
                      }
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
