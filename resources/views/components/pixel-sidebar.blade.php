<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/img/pixel-home.png" alt="Pixel-Home Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Pixel Home</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('device.list') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'device') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Devices
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('sensor.list') }}"
              class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'sensor') ? 'active' : ''}}">
              <i class="nav-icon fas fa-thermometer-half"></i>
              <p>
                Sensors
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('data-points.list') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'data-points') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                  Data points
              </p>
            </a>
          </li>
        <li class="nav-item">
            <a href="{{ route('graph.show') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'graph') ? 'active' : ''}}">
                <i class="nav-icon fas fa-chart-pie nav-icon"></i>
                <p>
                    Graph
                </p>
            </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
