@extends('admins.index')
@section('title')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('header')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid mb-3">

        <div class="col-md-12 mt-3">
            <!-- BAR CHART -->
            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover align-items-center">
                        <thead class='text-center col-12'>
                            <tr>
                                <th class='col-3 '>พื้นที่</th>
                                <th class='col-3'>ระดับ</th>
                                <th class='col-4'>Performance (%)</th>
                            </tr>
                        </thead>
                        <tbody class='align-items-center text-center'>
                            <tr>
                                <td>กาฬสินธุ์</td>
                                <td class="star-container" data-rating="1"></td>
                                <td>
                                    <div class="progress-container" data-value="30">
                                        <div class="progress-bar"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ขอนแก่น</td>
                                <td class="star-container" data-rating="5"></td>
                                <td>
                                <div class="progress-container" data-value="65">
                                        <div class="progress-bar"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>มหาสารคาม</td>

                                <td class="star-container" data-rating="3"></td>
                                <td>
                                <div class="progress-container" data-value="30">
                                        <div class="progress-bar"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>ร้อยเอ็ด</td>
                                <td class="star-container" data-rating="1"></td>
                                <td>
                                   
                                <div class="progress-container" data-value="50">
                                        <div class="progress-bar"></div>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>ภน.2.1</td>
                                <td><i class="fas fa-star text-warning"><i class="fas fa-star text-warning"><i
                                                class="fas fa-star text-dark"><i class="fas fa-star text-dark"><i
                                                        class="fas fa-star text-dark"></i></td>
                                <td>
                                <div class="progress-container" data-value="80">
                                        <div class="progress-bar"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card card-dark mt-3">

                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">ติดตั้ง FTTx ได้ภายใน 3 วัน (ข้อมูล ประจำเดือน เดือนนี้)</h3>

                        <div class="card-tools">
                            <a href="importdata" class="btn bg-light ">
                                <i class="d-flex justify-content-end "></i> Import
                            </a>
                            <button type="button" class="btn bg-gradient-warning">Export</button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="text-center ">
                                    <tr>
                                        <th rowspan="2" class="col-data">ดูข้อมูล</th>
                                        <th rowspan="2" class="col-department">ส่วนงาน</th>
                                        <th rowspan="2" class="col-count">จำนวนวงจร</th>
                                        <th rowspan="2" class="col-doc-time">ระยะเวลาเตรียมเอกสารรวม (วัน)</th>
                                        <th rowspan="2" class="col-process-time">ระยะเวลาดำเนินการรวม (วัน)</th>
                                        <th colspan="7">ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร</th>
                                        <th rowspan="2" class="col-total-time">รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร (วัน)
                                        </th>
                                        <th rowspan="2" class="col-install-count">จำนวนวงจรที่ติดตั้งภายใน 3 วัน
                                        </th>
                                        <th rowspan="2" class="col-install-percent">ร้อยละการติดตั้งภายใน 3 วัน</th>
                                    </tr>
                                    <tr>
                                        <th class="col-sdp">กำหนด SDP/ODP (วัน)</th>
                                        <th class="col-cable">โยงสาย (วัน)</th>
                                        <th class="col-config">Config NMS (วัน)</th>
                                        <th class="col-schedule">นัดหมายและกำหนดช่าง (วัน)</th>
                                        <th class="col-wait-customer">รอลูกค้า (วัน)</th>
                                        <th class="col-install">ลากสายและติดตั้ง ONT (วัน)</th>
                                        <th class="col-close-job">ปิดงาน (วัน)</th>
                                    </tr>
                                </thead>
                                <tbody class='text-center align-items-center'>
                                    <tr>
                                        <td><button type="button" class="btn btn-info btn-warning"><i
                                                    class="fas fa-search"></i></button></td>
                                        <td>กาฬสินธุ์</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" class="btn btn-info btn-warning"><i
                                                    class="fas fa-search"></i></button></td>
                                        <td>ขอนแก่น</td>
                                        <td>ooo0</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" class="btn btn-info btn-warning"><i
                                                    class="fas fa-search"></i></button></td>
                                        <td>มหาสารคาม</td>
                                        <td>ooo0</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" class="btn btn-info btn-warning"><i
                                                    class="fas fa-search"></i></button></td>
                                        <td>ร้อยเอ็ด</td>
                                        <td>ooo0</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                    </tr>
                                    <tr>
                                        <td><button type="button" class="btn btn-info btn-warning"><i
                                                    class="fas fa-search"></i></button></td>
                                        <td>ภน.2.1</td>
                                        <td>ooo0</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                        <td>ooo</td>
                                    </tr>

                                    <!-- เพิ่มข้อมูลอื่น ๆ -->
                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>



        </div>
    </div>
</section>
</section>
@endsection

@section('script')

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<style>
    .text-warning {
        color: gold;
    }

    .text-dark {
        color: lightgray;
    }
</style>

<script>
    // ฟังก์ชันสำหรับแปลงค่าคะแนนเป็นดาว
    function renderStarsForAll() {
        const starContainers = document.querySelectorAll(".star-container");
        starContainers.forEach(container => {
            const rating = parseFloat(container.getAttribute("data-rating")); // รับค่าคะแนนจาก data-rating
            container.innerHTML = ""; // เคลียร์ค่าก่อนหน้า

            for (let i = 1; i <= 5; i++) {
                const star = document.createElement("i");
                if (i <= Math.floor(rating)) {
                    star.className = "fas fa-star text-warning"; // ดาวเต็ม
                } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                    star.className = "fas fa-star-half-alt text-warning"; // ดาวครึ่ง
                } else {
                    star.className = "fas fa-star text-dark"; // ดาวว่าง
                }
                container.appendChild(star);
            }
        });
    }

    // เรียกใช้งานเมื่อโหลดหน้าเสร็จ
    renderStarsForAll();
</script>


<script>
    // ฟังก์ชันแสดงผลหลอดเปอร์เซ็นต์
    function updateProgressBars() {
        // ดึงองค์ประกอบทุก progress-container
        const containers = document.querySelectorAll('.progress-container');

        containers.forEach(container => {
            const value = parseInt(container.getAttribute('data-value')); // รับค่าจาก data-value
            const progressBar = container.querySelector('.progress-bar');

            // ตั้งค่าขนาดและข้อความ
            progressBar.style.width = value + '%';
            progressBar.textContent = value + '%';

            // กำหนดสีตามเงื่อนไข
            if (value < 50) {
                progressBar.className = 'progress-bar red';
            } else if (value < 80) {
                progressBar.className = 'progress-bar yellow';
            } else {
                progressBar.className = 'progress-bar green';
            }
        });
    }

    // เรียกใช้งานฟังก์ชันเมื่อโหลดหน้าเสร็จ
    updateProgressBars();
</script>

<style>
    .progress-container {
        width: 100%;
        max-width: 100%;
        background-color: #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .progress-bar {
        height: 25px;
        width: 100;
        text-align: center;
        line-height: 30px;
        color: white;
        transition: width 0.3s ease;
    }

    .red {
        background-color: Crimson;
    }

    .yellow {
        background-color: gold;
        color: black;
    }

    .green {
        background-color: SeaGreen;
    }
</style>

<script>

    $(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'], // ป้ายกำกับเดือน
            datasets: [
                {
                    label: 'รายได้จริง',
                    backgroundColor: 'rgb(60, 179, 113)', // สีสำหรับรายได้
                    borderColor: 'rgb(60, 179, 113)',
                    data: [46.83, 47.6, 48.2, 48.25, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83, 46.83,] // ข้อมูลรายได้
                },
                {
                    label: 'เป้าหมาย',
                    backgroundColor: 'rgba(210, 214, 222, 1)', // สีสำหรับเป้าหมาย
                    borderColor: 'rgba(210, 214, 222, 1)',
                    data: [52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34, 52.34,] // ข้อมูลเป้าหมาย
                }
            ]
        };

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + tooltipItem.yLabel.toLocaleString() + ' บาท';
                    }
                }
            },
            // scales: {
            //     yAxes: [{
            //         ticks: {
            //             beginAtZero: true, // เริ่มจาก 0
            //             callback: function (value) {
            //                 return value.toLocaleString() + ' บาท'; // แสดงตัวเลขแบบมีคอมม่า
            //             }
            //         },
            //         // scaleLabel: {
            //         //     display: true,
            //         //     labelString: 'จำนวนเงิน (บาท)' // ชื่อแกน Y
            //         // }
            //     }],
            //     xAxes: [{
            //         scaleLabel: {
            //             display: true,
            //             labelString: 'เดือน' // ชื่อแกน X
            //         }
            //     }]
            // }
        };

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>
@endsection