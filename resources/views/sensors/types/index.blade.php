@extends('adminlte::page')


@section('content')


<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensor Types</h3>
                    <div class="card-tools">
                        {{ $sensorTypes->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensorTypes as $sensorType)
                            <tr>
                                <th scope="row">{{ $sensorType->id }}</th>
                                <td>{{ $sensorType->name }}</td>
                                <td><a href="{{ url("/sensor-type/{$sensorType->id}/edit") }}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                        
                  <a href="/sensor-type/create" class="btn btn-primary">Add Sensor Type</a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

@stop
