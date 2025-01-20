@extends('admins.index')
@section('title')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('header')
ติดตั้ง FTTx ได้ภายใน 3 วัน
@endsection
@section('css')
<link rel="stylesheet" href="{{ URL::asset('custom/css/custom-style.css') }}">
<style>

</style>
@endsection
@section('content')



<!-- navigate -->
<h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
        <a href="{{ route('home') }}" class="">
            หน้าแรก
        </a>
        /
    </span> รายได้แยกตามบริการ Home Location (MC)</h4>


<div class='card'>
    <div class="d-flex justify-content-between align-items-center gap-2">
        <!-- หัวข้อ -->
        <h5 class="card-header text-dark">
            รายได้
        </h5>


        <div class="d-flex align-items-center gap-2">


            <!-- ฟอร์มเลือกปี -->
            <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET" class="d-inline"
                id="yearForm">
            </form>

            <!-- ปุ่ม Import -->
            @if (Auth::user()->permission['manage_dashboard'] ?? false)
                <a href="{{ route('importdata') }}" class="btn-fixed-size btn bg-yellow btn-fixed-size">
                    <i class="fas fa-file-import"></i> Import
                </a>
            @endif

            <!-- ฟอร์ม Export -->
            <button type="button" class="btn bg-dark btn-fixed-size" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-file-export"></i> Export
            </button>

            <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                <i class="fas fa-question-circle"></i>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body d-flex justify-content-center align-items-center flex-column" style="height: 400px;">
            <canvas id="myPieChart" style="max-width: 300px; max-height: 300px;"></canvas>
        </div>
    </div>
</div>


<div class="d-flex justify-content-around col-12 mt-3">
    <!-- กราฟที่ 1 -->
    <div class="card col-6">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h5 class="card-header text-dark">ตป.1</h5>
            <div class="d-flex align-items-center gap-2"></div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-center align-items-center flex-column" style="height: 400px;">
                <canvas id="myPieChart_tp1" style="max-width: 300px; max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- กราฟที่ 2 -->
    <div class="card col-6">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h5 class="card-header text-dark">ตป.2</h5>
            <div class="d-flex align-items-center gap-2"></div>
        </div>
        <div class="card">
            <div class="card-body d-flex justify-content-center align-items-center flex-column" style="height: 400px;">
                <canvas id="myPieChart_tp2" style="max-width: 300px; max-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>



<div class="card mt-3 ">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <!-- หัวข้อ -->
        <h5 class="card-header text-dark">
            รายได้
        </h5>


        <div class="d-flex align-items-center gap-2">

            <!-- ฟอร์มเลือกปี -->
            <form action="{{ route('viewInstallFTTxYear', ['year' => now()->year]) }}" method="GET" class="d-inline"
                id="yearForm1">

            </form>
            <!-- ปุ่ม Import -->
            @if (Auth::user()->permission['manage_dashboard'] ?? false)
                <a href="{{ route('importdata') }}" class="btn-fixed-size btn bg-yellow">
                    <i class="fas fa-file-import"></i> Import
                </a>
            @endif

            <!-- ฟอร์ม Export -->
            <button type="button" class="btn bg-dark btn-fixed-size" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-file-export"></i> Export
            </button>

            <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                <i class="fas fa-question-circle"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class='table table-bordered table-hover text-center'>
                <thead class='bg-dark text-center'>
                    <tr>
                        <th>ดูข้อมูล</th>
                        <th>พื้นที่</th>
                        <th>รายได้รวม</th>
                        <th>Hard Infrastructure</th>
                        <th>International</th>
                        <th>Mobile</th>
                        <th>FixedLine + BB</th>
                        <th>Digital</th>
                        <th>ICT Solution</th>
                        <th>กลุ่มบริการอื่นไม่ใช่โทรคมนาคม</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>กาฬสินธุ์</td>
                        <td>81.934</td>
                        <td>0.059</td>
                        <td>0</td>
                        <td>5.847</td>
                        <td>74.701</td>
                        <td>0.135</td>
                        <td>1.191</td>
                        <td>0.001</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>ขอนแก่น</td>
                        <td>189.542</td>
                        <td>0.326</td>
                        <td>0.039</td>
                        <td>33.779</td>
                        <td>148.13</td>
                        <td>0.619</td>
                        <td>6.646</td>
                        <td>0.002</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>มหาสารคาม</td>
                        <td>103.525</td>
                        <td>0</td>
                        <td>0.001</td>
                        <td>5.533</td>
                        <td>94.556</td>
                        <td>0.073</td>
                        <td>3.362</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>ร้อยเอ็ด</td>
                        <td>96.757</td>
                        <td>0.371</td>
                        <td>0.003</td>
                        <td>8.416</td>
                        <td>85.415</td>
                        <td>0.041</td>
                        <td>2.51</td>
                        <td>0</td>
                    </tr>
                    <tr class = 'bg-dark'>
                        <td colspan="2">ภน.2.1</td>
                        <td>471.756</td>
                        <td>0.756</td>
                        <td>0.044</td>
                        <td>53.575</td>
                        <td>402.8</td>
                        <td>0.868</td>
                        <td>13.709</td>
                        <td>0.003</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>เลย</td>
                        <td>97.218</td>
                        <td>0.152</td>
                        <td>0.003</td>
                        <td>4.102</td>
                        <td>83.592</td>
                        <td>1.55</td>
                        <td>7.817</td>
                        <td>0.001</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>หนองบัวลำภู</td>
                        <td>53.864</td>
                        <td>0.103</td>
                        <td>0.002</td>
                        <td>3.032</td>
                        <td>48.718</td>
                        <td>0.085</td>
                        <td>1.924</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>หนองคาย</td>
                        <td>90.282</td>
                        <td>0.064</td>
                        <td>0.025</td>
                        <td>7.517</td>
                        <td>79.295</td>
                        <td>0.138</td>
                        <td>3.243</td>
                        <td>0.001</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>อุดรธานี</td>
                        <td>166.919</td>
                        <td>1.093</td>
                        <td>0.04</td>
                        <td>17.39</td>
                        <td>137.928</td>
                        <td>1.404</td>
                        <td>9.02</td>
                        <td>0.044</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>บึงกาฬ</td>
                        <td>51.081</td>
                        <td>0.096</td>
                        <td>0</td>
                        <td>2.911</td>
                        <td>47.179</td>
                        <td>0.001</td>
                        <td>0.882</td>
                        <td>0.012</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>สกลนคร</td>
                        <td>144.455</td>
                        <td>0.207</td>
                        <td>0.003</td>
                        <td>11.689</td>
                        <td>123.781</td>
                        <td>0.172</td>
                        <td>8.602</td>
                        <td>0.002</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>นครพนม</td>
                        <td>88.17</td>
                        <td>0.161</td>
                        <td>0.002</td>
                        <td>4.38</td>
                        <td>77.386</td>
                        <td>0.826</td>
                        <td>5.412</td>
                        <td>0.003</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                        <td>มุกดาหาร</td>
                        <td>57.497</td>
                        <td>0.054</td>
                        <td>0.021</td>
                        <td>9.365</td>
                        <td>46.6</td>
                        <td>0.248</td>
                        <td>1.186</td>
                        <td>0.023</td>
                    </tr>
                    <tr class = 'bg-dark'>
                        <td colspan="2">ภน.2.2</td>
                        <td>749.376</td>
                        <td>1.93</td>
                        <td>0.098</td>
                        <td>60.386</td>
                        <td>644.459</td>
                        <td>4.334</td>
                        <td>38.085</td>
                        <td>0.085</td>
                    </tr>
                    <tr class = 'bg-dark text-white'>
                        <td colspan="2">ภน.2</td>
                        <td>1221.132</td>
                        <td>2.686</td>
                        <td>0.142</td>
                        <td>113.961</td>
                        <td>1047.259</td>
                        <td>5.202</td>
                        <td>51.794</td>
                        <td>0.088</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>




<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">คำอธิบายข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <p>
                    รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                    หน้าหลัก รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                </p>
                <p>
                    หมายเหตุ : รายงานระยะเวลาเฉลี่ยในการติดตั้ง ตามศูนย์บริการติดตั้ง
                </p>
                <p>
                    • จำนวนวงจร : จะนับเฉพาะใบคำขอที่ทำการปิดงานเรียบร้อยบนระบบ FTTxSM เท่านั้น (ไม่รวมข้อมูลใบคำขอที
                    import มาจากสผ.และใบคำขอที่ยังไม่เคยปิดงานเรียบร้อย) ตามช่วงเวลาที่เลือก
                </p>
                <p>
                    • ระยะเวลาเตรียมข้อมูลรวม : ยอดรวมระยะเวลาที่ใช้ในเตรียมเอกสารของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่วันที่สร้างคำขอ - รับชำระเงิน
                </p>
                <p>
                    • ระยะเวลาดำเนินการรวม : ยอดรวมระยะเวลาที่ใช้ในการติดตั้งของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้น ช่วงรอลูกค้า
                </p>
                <p>
                    • ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร :

                </p>
                <p>
                    - กำหนดSDP/ODP :
                </p>
                <p>
                    >> กรณีส่งงานโยงสายถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงานโยงสาย หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีส่งงานNMSถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - โยงสาย (ถ้าส่งงาน) : ยอดรวมจำนวนวัน นับจากวันที่ส่งงานโยงสายจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - การดำเนินการของ NMS, นัดหมายและกำหนดช่าง, ปิดงาน : ยอดรวมจำนวนวัน
                    นับจากวันที่รับงานมาดำเนินการจนถึงวันที่จ่ายงานให้งานถัดไป หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - รอลูกค้า :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่ติดตั้ง หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่นัดหมายลูกค้า หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - ลากสายและติดตั้ง :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ติดตั้งจนถึงวันที่ส่งงานปิดงาน
                    หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่วันนัดหมายลูกค้าจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร : ระยะเวลารวม (ช่องที่ 3) หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • ร้อยละการติดตั้งภายใน 3 วัน : ร้อยละการปิดงานเรียบร้อยภายใน 3 วัน(รับชำระเงิน - ปิดงานเรียบร้อย
                    ยกเว้นช่วงรอลูกค้า) เมื่อเทียบกับ จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • กรณีมีการติดตั้งวงจร แต่ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจรเท่ากับ 0.00 :
                    ใช้ระยะเวลาในการดำเนินการเป็นระดับวินาที จึงไม่สามารถแสดงตัวเลขได้
                </p>
                <p>
                    • รายงานเดือนตุลา ที่มีตัวเลขติดลบในบางพื้นที่ ทางระบบกำลังดำเนินการตรวจสอบและแก้ไขค่ะ
                    เนื่องจากมีการเลือกวันที่ติดตั้งและส่งงานไม่ถูกต้อง
                </p>
            </div>

        </div>
    </div>
</div>

<!-- Modal Export -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export ข้อมูล</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- ฟิลด์สำหรับกรอกข้อมูล -->
                <form action="{{ route('export') }}" method="get" enctype="multipart/form-data" class="form-group">
                    @csrf
                    <div class="form-group">
                        <label for="year">ปี</label>
                        <input type="number" id="year" name="year" min="2014" max="3000" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="month">เดือน</label>
                        <select id="month" name="month" class="form-control" required>
                            <option value="" disabled selected>เลือกเดือน</option>
                            <option value="มกราคม">มกราคม</option>
                            <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                            <option value="มีนาคม">มีนาคม</option>
                            <option value="เมษายน">เมษายน</option>
                            <option value="พฤษภาคม">พฤษภาคม</option>
                            <option value="มิถุนายน">มิถุนายน</option>
                            <option value="กรกฎาคม">กรกฎาคม</option>
                            <option value="สิงหาคม">สิงหาคม</option>
                            <option value="กันยายน">กันยายน</option>
                            <option value="ตุลาคม">ตุลาคม</option>
                            <option value="พฤศจิกายน">พฤศจิกายน</option>
                            <option value="ธันวาคม">ธันวาคม</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success" id="confirmExport" disabled>Confirm Export</button>
            </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('script')
<style>
    .text-warning {
        color: gold;
    }

    .text-dark {
        color: lightgray;
    }
</style>


<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Hard Infrastructure', 'Internationonal', 'Mobile', 'FixedLine & BB', 'Digital', 'Digital', 'รายได้อื่น ๆ'],
            datasets: [{
                data: [2.686, 0.142, 113.961, 1047.259, 5.202, 51.797, 0.088],
                backgroundColor: ['#4fc133', '#f8ff2d', '#ff3e1d', '#ffab00', '#fff200', '#71dd37', '#20c997'],
                hoverBackgroundColor: ['#4fc133', '#f8ff2d', '#ff3e1d', '#ffab00', '#fff200', '#71dd37', '#20c997']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom', // จัดตำแหน่ง label ไว้ด้านล่าง
                    labels: {
                        boxWidth: 20, // ขนาดกล่องสีกำกับ
                        padding: 10 // ระยะห่างระหว่าง labels
                    }
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>


<script>
    // กราฟที่ ตป.1
    const ctx_tp1 = document.getElementById('myPieChart_tp1').getContext('2d');
    new Chart(ctx_tp1, {
        type: 'pie',
        data: {
            labels: ['Red', 'Blue', 'Yellow'],
            datasets: [{
                data: [25, 50, 25],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 10
                    }
                }
            }
        }
    });

    // กราฟ ตป.2
    const ctx_tp2 = document.getElementById('myPieChart_tp2').getContext('2d');
    new Chart(ctx_tp2, {
        type: 'pie',
        data: {
            labels: ['Green', 'Orange', 'Purple'],
            datasets: [{
                data: [40, 30, 30],
                backgroundColor: ['#4CAF50', '#FF9800', '#9C27B0'],
                hoverBackgroundColor: ['#4CAF50', '#FF9800', '#9C27B0']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        padding: 10
                    }
                }
            }
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (localStorage.getItem('status')) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: localStorage.getItem('status'),
                confirmButtonText: 'OK'
            }).then(() => {
                localStorage.removeItem('status');
            });
        } else {
            // ถ้าไม่มีใน localStorage ให้เช็ค session
            const status = '{{ session('status') }}';
            if (status) {
                localStorage.setItem('status', status);
                location.reload();
            }
        }
    });
</script>

<script>
    // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
    document.getElementById('yearInput').addEventListener('change', function () {
        document.getElementById('yearForm').submit();
    });
    // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
    document.getElementById('yearInput1').addEventListener('change', function () {
        document.getElementById('yearForm1').submit();
    });
    // เมื่อค่าใน input เปลี่ยนให้ส่งฟอร์มทันที
    document.getElementById('yearInput2').addEventListener('change', function () {
        document.getElementById('yearForm2').submit();
    });
</script>


<script>
    $(document).ready(function () {
        const latestYear = @json($latestYear ?? ''); // ใช้ปีปัจจุบันถ้าตัวแปรไม่มีค่า
        const confirmExportBtn = $('#confirmExport'); // ปุ่ม Confirm Export
        const month = $('#month'); // ปุ่ม Confirm Export

        fetchMonths(latestYear); // ดึงข้อมูลเดือนเมื่อเปิด Modal

        $('#year').val(latestYear); // ตั้งค่าปีเริ่มต้นเป็นปีที่ดึงมาจาก latestMonthData

        function fetchMonths(year) {
            // ตรวจสอบค่าของ year ก่อน
            if (!year || year.length !== 4 || isNaN(year)) {
                console.warn("Invalid year:", year);
                return; // ไม่ทำงานถ้าค่า year ไม่ถูกต้อง
            }

            $.ajax({
                url: "{{ route('api.existing.months') }}",
                method: "GET",
                data: {
                    year: year
                },
                success: function (response) {
                    const monthsWithData = response.map(item => item.month);
                    const monthSelect = $('#month');

                    // เคลียร์ตัวเลือกเดิม
                    monthSelect.empty();

                    if (monthsWithData.length === 0) {



                        // เพิ่ม option ว่าไม่มีข้อมูล
                        // ปิดการใช้งานปุ่ม Confirm Export
                        $('#no-data-msg').remove();
                        confirmExportBtn.prop('disabled', true);

                        monthSelect.after('<p id="no-data-msg" class="text-danger">ไม่มีข้อมูลในปีนี้</p>');
                        return;
                    }
                    $('#no-data-msg').remove();

                    // เปิดใช้งานปุ่ม Confirm Export
                    confirmExportBtn.prop('disabled', false);
                    // กรองค่าซ้ำจาก monthsWithData โดยใช้ Set
                    const uniqueMonths = [...new Set(monthsWithData)];
                    // เพิ่ม months ที่มีข้อมูล
                    uniqueMonths.forEach(function (month) {
                        monthSelect.append(`<option value="${month}">${month}</option>`);
                    });
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถดึงข้อมูลได้ โปรดลองอีกครั้ง',
                        confirmButtonText: 'ตกลง',
                        customClass: {
                            container: 'my-swal-container',
                            popup: 'my-swal-popup'
                        },
                        backdrop: true
                    });
                }
            });
        }

        // ดึงข้อมูลเมื่อ Modal เปิด
        $('#myModal').on('shown.bs.modal', function () {
            const selectedYear = $('#year').val();

        });

        // อัปเดตข้อมูลเมื่อป้อนหรือเปลี่ยนค่าปี
        $('#year').on('keydown', function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                const selectedYear = $(this).val();
                if (selectedYear.length === 4 && !isNaN(selectedYear)) {
                    fetchMonths(selectedYear);
                }
            }
        });

        $('#year').on('change', function () {
            const selectedYear = $(this).val();
            if (selectedYear.length === 4 && !isNaN(selectedYear)) {
                fetchMonths(selectedYear);
            }
        });
        fetchMonths(selectedYear);
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('alert'))
            Swal.fire({
                icon: 'error',
                title: 'ไม่พบข้อมูล',
                text: '{{ session('alert') }}',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection