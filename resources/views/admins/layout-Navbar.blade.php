<style>
  /* จัดการขนาดและจัดเรียง */
  .custom-navbar {
    display: flex;
    align-items: center;
    gap: 15px;
    /* ระยะห่างระหว่างแต่ละเมนู */
  }

  .nav-item {
    list-style: none;
  }

  .nav-link-main {
    display: flex;
    align-items: center;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    padding: 10px 15px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
  }

  /* สีพื้นฐาน */
  .nav-link-main.text-dark {
    color: #333;
  }

  /* การเปลี่ยนสีเมื่อ hover */
  .nav-link-main:hover {
    background-color: #f8f9fa;
    color: #ffc107;
    transform: scale(1.1);
    /* animation ขยายขนาด */
  }

  /* ไอคอนและข้อความจัดให้อยู่ตรงกลาง */
  .nav-link-main i {
    margin-right: 8px;
    font-size: 18px;
  }
  
  .d-flex {
  display: flex;
  align-items: center;
  gap: 10px;
}

  .app-icon {
    width: 60px;
    height: 60px;
    background-color: #f0f0f0;
    /* พื้นหลัง */
    border-radius: 15px;
    /* มุมโค้ง */
    display: flex;
    align-items: center;
    justify-content: center;

    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* เงา */
  }

  .app-icon i {
    font-size: 25px;
  }

  /* ทำให้ไอคอนขยายโดยไม่ขยับแถว */
  .app-icon {
    transition: transform 0.3s ease, background-color 0.3s ease;
  }

  a:hover .app-icon {
    transform: scale(1.2);
    /* ขยายไอคอนเมื่อวางเมาส์ */
    background-color: rgb(255, 187, 0);
    /* เปลี่ยนสีพื้นหลัง */
  }

  /* ขยายข้อความแต่ไม่ให้ขยับแถว */
  a:hover h5,
  a:hover h6 {
    color: rgb(255, 183, 0);
    /* เปลี่ยนสีข้อความ */
    transform: scale(1.1);
    /* ขยายข้อความเล็กน้อย */
    position: relative;
    /* ไม่ให้ตำแหน่งขยับ */
    z-index: 1;
    /* ทำให้ข้อความเด่นขึ้น */
    transition: color 0.3s ease, transform 0.3s ease;
  }

  a h5,
  a h6 {
    transition: color 0.3s ease, transform 0.3s ease;
    color: #333;
    /* สีเริ่มต้นของข้อความ */
    transform: scale(1);
    /* ขนาดข้อความกลับสู่ปกติ */
  }

  /* เปลี่ยนสีข้อความเป็น warning เมื่อวางเมาส์บนปุ่ม */
  .nav-item button:hover i {
    color: #f39c12;
    /* สี warning */
  }



  .modal-content {
    height: 90vh;
    /* กำหนดความสูงคงที่ 80% ของหน้าจอ */
    max-height: 110vh;
    /* จำกัดไม่ให้เกิน 90% ของหน้าจอ */

  }

  .modal-body {
    overflow-y: auto;
    /* เปิดให้เลื่อนเฉพาะส่วนเนื้อหา */
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 shadow-sm rounded border p-1">
  <div class="container-fluid">
    <div class="layout-menu-toggle navbar-nav me-xl-0 d-xl-none">
      <a class="navbar-brand nav-link-main px-0 me-xl-4" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
      </a>
    </div>

    <ul class="navbar-nav me-auto mb-2 mb-lg-0 custom-navbar">
      <li class="nav-item">
        <a class="nav-link-main text-dark" aria-current="page" href="{{ route('home') }}">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          หน้าแรก
        </a>
      </li>
      @if (Auth::check())
      <li class="nav-item">
        <a class="nav-link-main text-dark" href="#" data-bs-toggle="modal" data-bs-target="#exLargeModal">
          <i class="fas fa-th"></i>
          แอป
        </a>
      </li>
      @endif
    </ul>

    <div class="d-flex align-items-center">
      @auth
      <div class="dropdown">
        <a class="nav-link-main dropdown-toggle hide-arrow" href="javascript:void(0);" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          @if (Auth::user()->profile_image)
          <img src="{{ Auth::user()->profile_image }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle">
          @else
          <img src="{{ asset('dist/img/defult_profile.jpg') }}" alt="Default Profile Image" class="w-px-40 h-auto rounded-circle">
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
      @guest
      <a href="{{ route('login') }}" class="btn btn-dark">
        <i class="fas fa-sign-in-alt mr-2"></i>{{ __('เข้าสู่ระบบ') }}
      </a>
      @endguest
    </div>
  </div>
</nav>

<div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark d-flex justify-content-center align-items-center w-100">
        <h3 class="modal-title text-white text-center pb-3" id="exampleModalLabel4">
          <i class="fas fa-grip-horizontal"></i> แอปจัดการทำงาน
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4><i class="fas fa-users-cog text-dark"></i> จัดการผู้ใช้</h4>
        <hr>
        <div class="row text-start">
          <div class="row">
            <div class="col-3 mb-4">
              <a href="{{ route('users.list') }}" class="text-decoration-none">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="app-icon bg-orange d-flex justify-content-center align-items-center">
                      <i class="fas fa-address-book"></i>
                    </div>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">รายชื่อผู้ใช้งาน</h5>
                    <h6 class="text-muted mb-0">ตรวจสอบรายชื่อผู้ใช้งาน</h6>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="{{ route('insertusers') }}" class="text-decoration-none">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="app-icon bg-orange d-flex justify-content-center align-items-center">
                      <i class="fas fa-user-edit"></i>
                    </div>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">จัดการผู้ใช้งาน</h5>
                    <h6 class="text-muted mb-0">เพิ่ม ลบ แก้ไข หรือ ให้สิทธิการใช้งานแก่ผู้ใช้</h6>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="{{ route('insertusers') }}" class="text-decoration-none">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="app-icon bg-orange d-flex justify-content-center align-items-center">
                      <i class="fas fa-user-plus"></i>
                    </div>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">เพิ่มผู้ใช้งาน</h5>
                    <h6 class="text-muted mb-0">เพิ่มผู้ใช้งานในระบบ</h6>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="{{ route('insertusers') }}" class="text-decoration-none">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="app-icon bg-orange d-flex justify-content-center align-items-center">
                      <i class="fas fa-user-check"></i>
                    </div>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">อนุมัติสิทธิการใช้งาน</h5>
                    <h6 class="text-muted mb-0">อนุมัติคำขอเข้าใช้งานระบบ</h6>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="{{ route('insertusers') }}" class="text-decoration-none">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <div class="app-icon bg-orange d-flex justify-content-center align-items-center">
                      <i class="fas fa-history"></i>
                    </div>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">ประวัติการทำงาน</h5>
                    <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของผู้ใช้งาน</h6>
                  </div>
                </div>
              </a>
            </div>

          </div>
        </div>
        <h4><i class="fas fa-tachometer-alt"></i> Dashboard</h4>
        <hr>
        <div class="row">

          <div class="col-3 mb-4">
            <a href="{{ route('importdata') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-cyan d-flex justify-content-center align-items-center">
                    <i class="fas fa-chart-line"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการ Dashboard</h5>
                  <h6 class="text-muted mb-0">เพิ่ม ลบ แก้ไข Dashboard</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('viewInstallFTTx') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-cyan d-flex justify-content-center align-items-center">
                    <i class="fas fa-wrench"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">ติดตั้งภายใน 3 วัน</h5>
                  <h6 class="text-muted mb-0">ข้อมูลการติดตั้ง fttx ภายใน 3 วัน</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('insertusers') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-cyan d-flex justify-content-center align-items-center">
                    <i class="fas fa-history"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">ประวัติการทำงาน</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของข้อมูล Dashboard</h6>
                </div>
              </div>
            </a>
          </div>
        </div>

        <h4><i class="far fa-calendar-plus"></i> จัดการข่าวสาร</h4>
        <hr>
        <div class="row">

          <div class="col-3 mb-4">
            <a href="{{ route('newsfeed') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-pink d-flex justify-content-center align-items-center">
                    <i class="far fa-newspaper"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">รายการข่าวสาร</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลรายการ ข่าวสาร เอกสาร และแบบฟร์อม</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('listnewsfeed') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-pink d-flex justify-content-center align-items-center">
                    <i class="fas fa-file-alt"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการข่าวสาร</h5>
                  <h6 class="text-muted mb-0">เพิ่ม ลบ แก้ไข ข่าวสาร</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('insertusers') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-pink d-flex justify-content-center align-items-center">
                    <i class="fas fa-history"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">ประวัติการทำงาน</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของจัดการข่าวสาร</h6>
                </div>
              </div>
            </a>
          </div>

        </div>

        <h4><i class="fas fa-images"></i> จัดการรูปภาพ</h4>
        <hr>
        <div class="row">

          <div class="col-3 mb-4">
            <a href="{{ route('edit_banner') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-green d-flex justify-content-center align-items-center">
                    <i class="fas fa-images"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการปก</h5>
                  <h6 class="text-muted mb-0">จัดการปกหน้าแรกของเพจ</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('insertusers') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-green d-flex justify-content-center align-items-center">
                    <i class="fas fa-history"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">ประวัติการทำงาน</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของจัดการรูปภาพ</h6>
                </div>
              </div>
            </a>
          </div>

        </div>

        <h4><i class="fas fa-calendar-alt"></i> จัดการกิจกรรม</h4>
        <hr>
        <div class="row">

          <div class="col-3 mb-4">
            <a href="{{ route('edit_banner') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-yellow d-flex justify-content-center align-items-center">
                    <i class="fas fa-calendar-plus"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการกิจกรรม</h5>
                  <h6 class="text-muted mb-0">เพิ่ม ลบ แก้ไข หมวดหมู่กิจกรรม</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('edit_banner') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-yellow d-flex justify-content-center align-items-center">
                    <i class="fas fa-tags"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการประเภทบริการ</h5>
                  <h6 class="text-muted mb-0">เพิ่ม ลบ แก้ไข ประเภทบริการ</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('edit_banner') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-yellow d-flex justify-content-center align-items-center">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">จัดการข้อมูลจังหวัด</h5>
                  <h6 class="text-muted mb-0">จัดการข้อมูลของจังหวัดและศูนย์บริการ</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('insertusers') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-yellow d-flex justify-content-center align-items-center">
                    <i class="fas fa-file-alt"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">แบบฟอร์มกิจกรรม</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของกิจกรรม</h6>
                </div>
              </div>
            </a>
          </div>

          <div class="col-3 mb-4">
            <a href="{{ route('insertusers') }}" class="text-decoration-none">
              <div class="row align-items-center">
                <div class="col-auto">
                  <div class="app-icon bg-yellow d-flex justify-content-center align-items-center">
                    <i class="fas fa-history"></i>
                  </div>
                </div>
                <div class="col">
                  <h5 class="mb-1">ประวัติการทำงาน</h5>
                  <h6 class="text-muted mb-0">แสดงข้อมูลประวัติทำงาน (Log) ของผู้ใช้งาน</h6>
                </div>
              </div>
            </a>
          </div>

        </div>

      </div>

      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>