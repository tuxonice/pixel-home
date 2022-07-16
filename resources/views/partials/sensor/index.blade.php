<x-app-layout>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sensors</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Sensors</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sensors</h3>
                    <div class="card-tools">
                        {{ $sensors->links('pagination.bootstrap-4') }}
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Symbol</th>
                            <th>Active</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sensors as $sensor)
                            <tr>
                                <th scope="row">{{ $sensor->id }}</th>
                                <td>{{ $sensor->name }}</td>
                                <td>{{ $sensor->unit }}</td>
                                <td>{{ $sensor->unit_symbol }}</td>
                                <td><i class="fas fa-{{ $sensor->active ? 'check text-success': 'times text-danger' }}"></i></td>
                                <td><a href="{{ url("/sensor/{$sensor->id}/edit") }}"><i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                  <a href="{{ route('sensor.new') }}" class="btn btn-primary">Add Sensor</a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
</div>
</div>


</div>
<!-- /.content-wrapper -->
</x-app-layout>
