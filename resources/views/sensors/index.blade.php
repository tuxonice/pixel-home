@extends('adminlte::page')


@section('content')


<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensors</h3>
                    <div class="card-tools">
                        {{ $sensors->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <th scope="row">{{ $sensor->id }}</th>
                                <td>{{ $sensor->code }}</td>
                                <td>{{ $sensor->name }}</td>
                                <td>{{ $sensor->location }}</td>
                                <td>{{ $sensor->type }}</td>
                                <td><a href="{{ url("/sensor/{$sensor->id}/edit") }}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                        
                  <a href="/sensor/create" class="btn btn-primary">Add Sensor</a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

@stop
