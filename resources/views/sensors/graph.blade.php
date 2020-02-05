@extends('adminlte::page')


@section('plugins.Chartjs', true)

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Line Chart</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" height="250"></canvas>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!-- /.col (RIGHT) -->
        </div><!-- /.row -->

    </section><!-- /.content -->


@stop


@section('js')
    <script>
        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            var labels = Array.apply(null, {length: 40}).map(Number.call, Number)
            var ctx = document.getElementById('lineChart').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'My First dataset',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [{{$yAxis}}]
                    }]
                },

                // Configuration options go here
                options: {}
            });
      });
    </script>
@stop