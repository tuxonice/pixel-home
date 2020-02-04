@extends('adminlte::page')


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensor Events</h3>

                    <div class="card-tools">
                        {{ $events->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Sensor</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Flood</th>
                            <th>Battery</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <th scope="row">{{ $event->id }}</th>
                                <td>{{ $event->sensor }}</td>
                                <td>{{ $event->temperature }}</td>
                                <td>{{ $event->humidity }}</td>
                                <td>{{ $event->flood }}</td>
                                <td>{{ $event->battery }}</td>
                                <td>{{ $event->added_on }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
@stop