<style>
    p {
        font-size: 0.75rem;
    }

    aside .nav-icon {
        font-size: 1rem !important;
        
    }

    .main-sidebar {
        width: 250;
        /* เปลี่ยนค่าตามต้องการ */
    }

    /* ทำให้พื้นหลังเป็นสี warning เมื่อ hover */
    .nav .nav-treeview .nav-item .nav-link:hover {
        background-color: #ffc107;
        /* สี warning */
        color: #212529 !important;
        /* ทำให้ข้อความเป็นสีดำเพื่อให้เด่น */
    }
</style>



<aside class="main-sidebar sidebar-dark-secondary elevation-4 ">
    <!-- Brand Logo -->
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-warning d-flex justify-content-center align-items-center ">
        <img src="{{ URL::asset('dist/img/monontlogo.png') }}" alt="AdminLTE Logo" class="brand-image" style="height: 100px;">
    </a>




    <!-- Sidebar -->
    <div class="sidebar bg-muted">
        <!-- Sidebar user panel (optional) -->


        <!-- Sidebar Menu -->
        <nav class="mt-1 ">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="https://intranet.ntplc.co.th/dir/?url=https://intranet.ntplc.co.th/home/start"
                        class="nav-link bg-warning text-center">

                        <p class="text-dark h5 ">INTRANET</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>หน้าแรก</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tasks"></i>
                        <p>หน้าที่ความรับผิดชอบ</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="/structure" class="nav-link">
                        <i class="fas fa-network-wired"></i>
                        <p>โครงสร้างส่วนวงาน</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users nav-icon"></i>
                        <p>บุคคลากร</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Link
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-dark">
                        <li class="nav-item">
                            <a href="https://drive.google.com/file/d/1m7ioawx3JNsXej061HbhKPppStksS83c/view"
                                class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>โครงสร้าง ภน.</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ผลการดำเนินงานสายงาน ภน.</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ผลการดำเนินงานด้านการตลาดสายงาน ภน.</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>คุณภาพบริการ </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>เอกสารประกอบการปฏิบัติงาน </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>งานตรวจสอบการพาดสายสื่อสารบนเสาร์ไฟฟ้าของ กฟภ. (RD03,RD05) </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>การบริการโครงข่ายอินเทอร์เน็ตสำหรับ สพฐ. </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Link ส่วนงาน
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-dark">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายกลยุทธ์การตลาด</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายวางแผนกลยุทธ์องค์กร</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ส่วนระเบียบ คำสั่ง</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายตลาดผลิตภัณฑ์โทรศัพท์และ
                                    บรอดแบนด์ (ทต.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายตลาดผลิตภัณฑ์สื่อสารข้อมูล
                                    (มต.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายตลาดผลิตภัณฑ์สื่อสารไร้สาย
                                    (สต.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายบริหารคุณภาพ (คต.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>สายงานดาวเทียมและโครงข่าย (ท.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายธุรกิจความปลอดภัยไซเบอร์</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายธุรกิจบริการดิจิทัล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายปฏิบัติการศูนย์ข้อมูล (ปต.)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายธุรกิจแลกเปลี่ยนข้อมูล</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-tag"></i>
                                <p>ฝ่ายธุรกิจคลาวด์และบิ๊กตาด้า</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Link ระบบงานต่างๆ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-dark">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>Executive Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>TSP</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>UMBO</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>CRM</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>Dept</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>SCOM Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="fas fa-link"></i>
                                <p>2Ldb</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon"></i>
                        <p>
                            Link กลุ่มขายและปฏิบัติการลูกค้า
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-dark">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                               <i class="fas fa-users-cog"></i>
                                <p>กลุ่มขายและปฏิบัติการลูกค้าภาคเหนือ
                                    ภน.1</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                               <i class="fas fa-users-cog"></i>
                                <p>กลุ่มขายและปฏิบัติการลูกค้า ภาค
                                    ตะวันออกเฉียงเหนือตอนบน ภน.2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                               <i class="fas fa-users-cog"></i>
                                <p>กลุ่มขายและปฏิบัติการลูกค้า ภาค
                                    ตะวันออกเฉียงเหนือตอนล่าง ภน.3</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                        <p>
                            Widgets
                            <span class="right badge badge-danger">item</span>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview bg-dark">
                        <li class="nav-item">
                            <a href="layouts.advanced" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>advanced</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="layouts.buttons" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>buttons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.calendar" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>calendar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.chartjs" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>chartjs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.form-general" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>form-general</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.ribbons" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>ribbons</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.flot" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>flot</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.invoice" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.ui-general" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>ui-general</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.modals" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>modals</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.editors" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>editors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.data" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.sliders" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>sliders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.profile" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="layouts.timeline" class="nav-link text-white">
                               <i class="fas fa-wrench"></i>
                                <p>timeline</p>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ตรวจสอบ URL ที่เปิดอยู่เพื่อ active ลิงก์ที่ตรงกับ URL
        const currentLocation = window.location.pathname;
        const menuLinks = document.querySelectorAll(".nav-link");

        menuLinks.forEach(link => {
            // ถ้า URL ของลิงก์ตรงกับ URL ที่เปิดอยู่ ให้เพิ่ม class active
            if (link.getAttribute("href") === currentLocation) {
                link.classList.add("active");
            }

            // เมื่อคลิก ให้ลบ class active ออกจากลิงก์อื่นแล้วเพิ่ม class active ให้กับลิงก์ที่คลิก
            link.addEventListener("click", function() {
                menuLinks.forEach(l => l.classList.remove("active"));
                link.classList.add("active");
            });
        });
    });
</script>
