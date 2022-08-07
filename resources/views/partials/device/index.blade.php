<x-app-layout>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Devices</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Devices</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Devices</h3>

                <div class="card-tools">
                  {{ $devices->links('pagination.bootstrap-4') }}
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
                      <th>code</th>
                      <th>active</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($devices as $device)
                    <tr>
                      <td>{{ $device->id }}</td>
                      <td>{{ $device->name }}</td>
                      <td>{{ $device->location }}</td>
                      <td>{{ $device->code }}</td>
                      <td><i class="fas fa-{{ $device->active ? 'check text-success' : 'times text-danger' }} "></i></td>
                      <td><a href="{{ route('device.edit', $device->id) }}"><i class="far fa-edit"></i></a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                  <a href="{{ route('device.new') }}" class="btn btn-primary">Add Device</a>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </x-app-layout>
