<nav class="main-header navbar navbar-expand navbar-warning navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="home" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
        @if(Auth::check() && Auth::user()->permission['manage_users'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('users.list')}}" class="nav-link text-dark"><i class="fas fa-users-cog"></i> จัดการผู้ใช้</a>
            </li>
        @endif

        @if(Auth::check() && Auth::user()->permission['manage_newsfeed'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('listnewsfeed')}}" class="nav-link text-dark"><i class="fas fa-newspaper"></i> จัดการเอกสารข่าว</a>
            </li>
        @endif

        @if(Auth::check() && Auth::user()->permission['manage_dashboard'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('importdata')}}" class="nav-link text-dark"><i class="fas fa-chart-line"></i> จัดการแดชบอร์ด</a>
            </li>
        @endif

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            @auth
            <a class="nav-link d-flex justify-content-center align-items-center" data-toggle="dropdown" href="#">
                @if(Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="User Avatar" class="img-size-50 img-circle mr-2">
                @else
                    <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-2">
                @endif
                <span>{{ Auth::user()->name }}</span>
            </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="profile" class="dropdown-item">แก้ไขโปรไฟล์</a>
                    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
            
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-dark">
                    <i class="fas fa-sign-in-alt mr-2"></i>{{ __('เข้าสู่ระบบ') }}
                </a>
            @endauth
        </li>
    </ul>
</nav>