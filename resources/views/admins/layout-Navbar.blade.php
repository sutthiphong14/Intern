<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded border p-2">
  <div class="container-fluid">
    <div class="layout-menu-toggle navbar-nav me-xl-0 d-xl-none">
      <a class="navbar-brand nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      แถบเครื่องมือ <span class="fas fa-chevron-down"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('home') }}"><i class="fas fa-users-cog"></i> หน้าแรก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('users.list') }}"><i class="fas fa-users-cog"></i> จัดการผู้ใช้</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('importdata') }}"><i class="fas fa-users-cog"></i> จัดการ Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="{{ route('listnewsfeed') }}"><i class="fas fa-newspaper"></i> จัดการเอกสารข่าว</a>
        </li>
      </ul>

      <!-- User -->
      @auth
      <div class="dropdown">
        <a
          class="nav-link dropdown-toggle hide-arrow"
          href="javascript:void(0);"
          id="userDropdown"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          @if (Auth::user()->profile_image)
          <img src="{{ Auth::user()->profile_image }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
          @else
          <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image" class="w-px-40 h-auto rounded-circle">
          @endif
          <span>{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="userDropdown">
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
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bx bx-power-off me-2"></i>
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </div>
      @else
      <a href="{{ route('login') }}" class="btn btn-dark">
        <i class="fas fa-sign-in-alt mr-2"></i>{{ __('เข้าสู่ระบบ') }}
      </a>
      @endauth
    </div>
  </div>
</nav>
