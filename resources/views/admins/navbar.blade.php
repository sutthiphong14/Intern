<nav class="main-header navbar navbar-expand navbar-warning navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="home" role="button"><i class="fas fa-bars"></i></a>
        </li>
        
        @if(Auth::user()->permission['manage_users'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('structure')}}" class="nav-link text-dark">เกี่ยวกับ NT</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="listusers" class="nav-link text-dark">จัดการผู้ใช้</a>
            </li>
        @endif

        @if(Auth::user()->permission['manage_newsfeed'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="newsfeed" class="nav-link text-dark">ข่าว</a>
            </li>
        @endif

        @if(Auth::user()->permission['manage_dashboard'] ?? false)
            <li class="nav-item d-none d-sm-inline-block">
                <a href="listreport" class="nav-link text-dark">รายงาน</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="viewreport" class="nav-link text-dark">ดูรายงาน</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="viewreport1" class="nav-link text-dark">ดูรายงาน1</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="viewInstallFTTx" class="nav-link text-dark">รายงานติดตั้ง 3 วัน</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="viewInstallFTTxprovin" class="nav-link text-dark">รายงานติดตั้ง จังหวัด</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="viewInstallFTTxcenter" class="nav-link text-dark">รายงานติดตั้งศูนย์บริการ</a>
            </li>
        @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link d-flex justify-content-center align-items-center" data-toggle="dropdown" href="#">
                <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle">
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
        </li>
    </ul>
</nav>


