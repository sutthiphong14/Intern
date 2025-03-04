<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme ">
  <div class="app-brand demo ms-5">
    <a href="/" class="app-brand-link align-item-center">
      <img src="{{ URL::asset('dist/img/ntcolor.png') }}" alt="Logo" class="brand-image" style="height: 55px;">
      <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> -->
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow text-dark"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Route::is('home') ? 'active' : '' }}">
      <a href="/" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">หน้าแรก</div>
      </a>
    </li>
    <li class="menu-header small text-uppercase">
              <span class="menu-header-text text-dark">DashBoard</span>
            </li>


    <li class="menu-item {{ Route::is('type_list') ? 'active' : '' }}">
        <a href="{{ route('type_list') }}" class="menu-link">
            <i class="menu-icon fas fa-calendar-plus"></i>
            <div data-i18n="Analytics">กิจกรรม</div>
        </a>
    </li>


    <li class="menu-item {{ Route::is('viewInstallFTTx') ? 'active' : '' }}">
      <a href="{{ route('viewInstallFTTx') }}" class="menu-link">
        <i class="menu-icon fas fa-wrench"></i>
        <div>ติดตั้ง FTTx ได้ภายใน 3 วัน</div>
      </a>
    </li>
    
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-dark">แบบฟอร์ม</span>
    </li>
    <li class="menu-item ">
      <a href="{{ route('viewInstallFTTx') }}" class="menu-link">
        <i class=" menu-icon fas fa-file-alt"></i>
        <div> แบบฟอร์มเก็บข้อมูลลูกค้า</div>
      </a>
    </li>
    
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-dark"> อัลบัมรูปภาพกิจกรรม</span>
    </li>
    <li class="menu-item {{ Route::is('events.list') ? 'active' : '' }}">
      <a href="{{ route('events.list') }}" class="menu-link">
        <i class="menu-icon fas fa-images"></i>
        <div> อัลบัมรูปภาพ</div>
      </a>
    </li>
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text text-dark">Link ส่วนงาน</span>
    </li>
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายกลยุทธ์การตลาด</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายวางแผนกลยุทธ์องค์กร</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ส่วนระเบียบ คำสั่ง</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายตลาดผลิตภัณฑ์โทรศัพท์และ
          บรอดแบนด์ (ทต.)</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายตลาดผลิตภัณฑ์สื่อสารข้อมูล
          (มต.)</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายบริหารคุณภาพ (คต.)</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> สายงานดาวเทียมและโครงข่าย (ท.)</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon fas fa-tag"></i>
        <div> ฝ่ายธุรกิจบริการดิจิทัล</div>
      </a>
    </li>



  </ul>






</aside>
