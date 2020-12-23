<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/storage/admin_image') }}/{{ Auth::guard('admin')->user()->image  }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ ucwords(Auth::guard('admin')->user()->name) }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
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

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            @if(Session::get('page')== "dashboard")
              <?php $active = "active"?>
            @else  
              <?php $active = ""?>
            @endif
            <a href="{{ route('dashboard') }}" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- setting -->
          <li class="nav-item menu-open">
            @if(Session::get('page')== "settings" || Session::get('page')== "update-admin-details")
              <?php $active = "active"?>
            @else  
              <?php $active = ""?>
            @endif
            <a href="#" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Seetings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')== "settings")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('settings') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Password</p>
                </a>
              </li>
              @if(Session::get('page')== "update-admin-details")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('updateAdminDetails') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Details</p>
                </a>
              </li>
            </ul>
          </li>


          <!-- catalogues -->
          <li class="nav-item menu-open">
            @if(Session::get('page')== "sections" || Session::get('page')== "barnds" || Session::get('page')== "categories" || Session::get('page')== "products")
              <?php $active = "active"?>
            @else  
              <?php $active = ""?>
            @endif
            <a href="#" class="nav-link {{ $active }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Catalogues
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')== "sections")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('section.index') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sections</p>
                </a>
              </li>
              @if(Session::get('page')== "barnds")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('brand.index') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brands</p>
                </a>
              </li>
              @if(Session::get('page')== "categories")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categories</p>
                </a>
              </li>
              @if(Session::get('page')== "products")
                <?php $active = "active"?>
              @else  
                <?php $active = ""?>
              @endif
              <li class="nav-item">
                <a href="{{ route('product.index') }}" class="nav-link {{ $active }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>products</p>
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