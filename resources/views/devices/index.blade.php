@extends('adminlte::page')


@section('content')


<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Devices</h3>
                    <div class="card-tools">
                        {{ $devices->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Code</th>
                            <th>Active</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($devices as $device)
                            <tr>
                                <th scope="row">{{ $device->id }}</th>
                                <td>{{ $device->name }}</td>
                                <td>{{ $device->location }}</td>
                                <td>{{ $device->code }}</td>
                                <td>{{ $device->active }}</td>
                                <td><a href="{{ url("/device/{$device->id}/edit") }}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                        
                  <a href="/device/create" class="btn btn-primary">Add Device</a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>

@stop
