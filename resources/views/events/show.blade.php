@extends('adminlte::page')


@section('content')

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
                    <select class="form-control" id="sensor" name="sensor">
                        <option value=""> --All sensors-- </option>
                        @foreach($sensorList as $sensor)
                          <option value="{{$sensor->id}}" {{ $selectedSensor == $sensor->id ? 'selected="selected"' : '' }}>{{$sensor->name}}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                    <label for="sensor">Location</label>
                    <select class="form-control" id="location" name="location">
                        <option value=""> --All locations-- </option>
                        @foreach($locationList as $location)
                          <option value="{{ $location->name }}" {{ $selectedLocation == $location->name ? 'selected="selected"' : '' }}>{{ $location->name }}</option>
                        @endforeach
                        </select>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensor Events</h3>
                    <div class="card-tools">
                        {{ $events->appends(['sensor' => $selectedSensor])->links() }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Sensor</th>
                            <th>Temperature (ºC)</th>
                            <th>Humidity (%)</th>
                            <th>Flood</th>
                            <th>Battery</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($events) > 0)    
                            @foreach($events as $event)
                                <tr>
                                    <th scope="row">{{ $event->id }}</th>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ number_format($event->temperature, 2, '.', ' ') }} 
                                    @if($event->diffTemperature)
                                        <small style="color: {{$event->diffTemperature < 0 ? 'red':'green'}}">({{ $event->diffTemperature }})</small>
                                    @endif
                                    </td>
                                    <td>{{ $event->humidity }} 
                                    @if($event->type === 'HT' && $event->diffHumidity)
                                        <small style="color: {{$event->diffHumidity < 0 ? 'red':'green'}}">({{ $event->diffHumidity }})</small>
                                    @endif
                                    </td>
                                    <td>{{ $event->flood }}</td>
                                    <td>{{ $event->battery }} </td>
                                    <td>{{ $event->type }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>{{ $event->added_on }}
                                    @if($event->diffTime)
                                        <small style="color: blue">({{ $event->diffTime }})</small>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center"><b>No records to show</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
@stop
