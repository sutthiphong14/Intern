<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
  id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center " id="navbar-collapse">
    <!-- navitem -->
    <div class="navbar-nav align-items-center ">
    <li class="nav-item lh-1 me-3 ">
        <a href="home" class="">
        <i class="menu-icon tf-icons bx bx-home-circle"></i> หน้าแรก
        </a>
      </li>
      @if (Auth::check() && Auth::user()->permission['manage_users'] ?? false)
      <li class="nav-item lh-1 me-3">
        <a href="{{ route('users.list') }}" class="">
          <i class="fas fa-users-cog"></i> จัดการผู้ใช้
        </a>
      </li>
      @endif

      @if (Auth::check() && Auth::user()->permission['manage_dashboard'] ?? false)
      <li class="nav-item lh-1 me-3">
        <a href="{{ route('importdata') }}" class="">
          <i class="fas fa-users-cog"></i> จัดการ Dashboard
        </a>
      </li>
      @endif



      @if (Auth::check() && Auth::user()->permission['manage_newsfeed'] ?? false)

            <li class="nav-item lh-1 me-3">
        <a href="{{ route('listnewsfeed') }}" class="">
          <i class="fas fa-newspaper"></i> จัดการเอกสารข่าว
        </a>
      </li>
        @endif

    </div>
    <!-- /navitem -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Place this tag where you want the button to render. -->
      <li class="nav-item lh-1 me-3">
        -----
      </li>


      <!-- User -->
      @auth
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        @if (Auth::user()->profile_image)
                        <img src="{{ Auth::user()->profile_image }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                    @else
                        <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image" class="w-px-40 h-auto rounded-circle">
                    @endif
                    <span>{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                <div class="avatar avatar-online">
                @if (Auth::user()->profile_image)
                        <img src="{{ Auth::user()->profile_image }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
                    @else
                        <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image" class="w-px-40 h-auto rounded-circle">
                    @endif
                    
          </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('profile') }}">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <span class="d-flex align-items-center align-middle">
                <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                <span class="flex-grow-1 align-middle">Billing</span>
                <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
              </span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
          
            
              <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                                 <i class="bx bx-power-off me-2"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            
          </li>
        </ul>
      </li>
      <!--/ User -->
       @else
                <a href="{{ route('login') }}" class="btn btn-dark">
                    <i class="fas fa-sign-in-alt mr-2"></i>{{ __('เข้าสู่ระบบ') }}
                </a>
            @endauth
    </ul>
  </div>
</nav>

<!-- / Navbar -->

<!-- Content wrapper -->

<!-- Content wrapper -->