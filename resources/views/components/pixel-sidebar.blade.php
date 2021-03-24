<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="/img/pixel-home.png" alt="Pixel-Home Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Pixel Home</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!--
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>
      -->
      <!-- SidebarSearch Form -->
      <!--
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'device') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'device') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Devices
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('device.list') }}" 
                class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'list') ? 'active' : ''}}">
                  <i class="fas fa-bars nav-icon icon-small"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('device.new') }}" 
                class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'new') ? 'active' : ''}}">
                  <i class="far fa-file nav-icon icon-small"></i>
                  <p>New</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'sensor') ? 'menu-open' : ''}}">
            <a href="#" 
              class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'sensor') ? 'active' : ''}}">
              <i class="nav-icon fas fa-thermometer-half"></i>
              <p>
                Sensors
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('sensor.list') }}" 
                  class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'list') ? 'active' : ''}}">
                  <i class="fas fa-bars nav-icon icon-small"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sensor.new') }}" 
                  class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'new') ? 'active' : ''}}">
                  <i class="far fa-file nav-icon icon-small"></i>
                  <p>New</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'data-points') ? 'menu-open' : ''}}">
            <a href="#" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'data-points') ? 'active' : ''}}">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Statistics
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('data-points.list') }}" class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'list') ? 'active' : ''}}">
                  <i class="fas fa-bars nav-icon icon-small"></i>
                  <p>Data points</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('graph.show') }}" class="nav-link {{ Illuminate\Support\Str::endsWith(Route::currentRouteName(), 'show') ? 'active' : ''}}">
                  <i class="fas fa-chart-pie nav-icon icon-small"></i>
                  <p>Graph</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>