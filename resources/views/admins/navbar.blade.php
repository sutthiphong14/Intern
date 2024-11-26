

<nav class="main-header navbar navbar-expand navbar-warning navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav  ">
        <li class="nav-item ">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="{{route('structure')}}" class="nav-link text-dark">เกี่ยวกับ NT</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="newsfeed" class="nav-link text-dark">ข่าว</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="listusers" class="nav-link text-dark">จัดการผู้ใช้</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="listreport" class="nav-link text-dark">รายงาน</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="viewreport" class="nav-link text-dark">ดูรายงาน</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="viewreport1" class="nav-link text-dark">ดูรายงาน1</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="viewreport2" class="nav-link text-dark">ดูรายงาน2</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ">
            <a href="viewreport3" class="nav-link text-dark">ดูรายงาน3</a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">NT NEWS</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Staff Directory/สมุดโทรศัพท์</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">ระบบงาน</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">App portal &nbsp;<i class="fas fa-tv text-light"></i></a>

        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">HP portal &nbsp; <i class="fas fa-user-friends text-light"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">NT1 Network &nbsp; <i
                    class="fas fa-project-diagram nav-icon text-light"></i></a>
        </li> --}}
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


