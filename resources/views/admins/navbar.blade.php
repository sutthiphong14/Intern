<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded border p-2">
  <div class="container-fluid">
    <div class="layout-menu-toggle navbar-nav me-xl-0 d-xl-none ">
      <a class="navbar-brand nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-dark" aria-current="page" href="{{ route('home') }}"
            onmouseover="this.classList.replace('text-dark', 'text-warning')"
            onmouseout="this.classList.replace('text-warning', 'text-dark')">
            <i class="menu-icon tf-icons bx bx-home-circle"></i> หน้าแรก
          </a>
        </li>
        @if (Auth::check() && Auth::user()->permission['manage_users'] ?? false)
        <li class="nav-item">
          <a class="nav-link text-dark" aria-current="page" href="{{ route('users.list') }}"
            onmouseover="this.classList.replace('text-dark', 'text-warning')"
            onmouseout="this.classList.replace('text-warning', 'text-dark')">
            <i class="fas fa-users-cog"></i> จัดการผู้ใช้
          </a>
        </li>
        @endif
        @if (Auth::check() && Auth::user()->permission['manage_dashboard'] ?? false)
        <li class="nav-item">
          <a class="nav-link text-dark" aria-current="page" href="{{ route('importdata') }}"
            onmouseover="this.classList.replace('text-dark', 'text-warning')"
            onmouseout="this.classList.replace('text-warning', 'text-dark')">
            <i class="fas fa-users-cog"></i> จัดการ Dashboard
          </a>
        </li>
        @endif
        @if (Auth::check() && Auth::user()->permission['manage_newsfeed'] ?? false)
        <li class="nav-item">
          <a class="nav-link text-dark" aria-current="page" href="{{ route('listnewsfeed') }}"
            onmouseover="this.classList.replace('text-dark', 'text-warning')"
            onmouseout="this.classList.replace('text-warning', 'text-dark')">
            <i class="fas fa-newspaper"></i> จัดการเอกสารข่าว
          </a>
        </li>
        @endif
      </ul>

      @auth
      <div class="dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" id="userDropdown"
          data-bs-toggle="dropdown" aria-expanded="false">
          @if (Auth::user()->profile_image)
          <img src="{{ Auth::user()->profile_image }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
          @else
          <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image"
            class="w-px-40 h-auto rounded-circle">
          @endif
          <span class="text-dark">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="userDropdown">
          <li>
            <a class="dropdown-item" href="{{ route('profile') }}">
              <i class="bx bx-user me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
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
      @endauth
    </div>
    @guest
    <a href="{{ route('login') }}" class="btn btn-dark">
      <i class="fas fa-sign-in-alt mr-2"></i>{{ __('เข้าสู่ระบบ') }}
    </a>
    @else
    <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      แถบเครื่องมือ <span class="fas fa-chevron-down"></span>
    </button>
    @endguest
  </div>
</nav>
