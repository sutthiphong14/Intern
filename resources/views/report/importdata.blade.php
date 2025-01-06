@extends('admins.index')

@section('title')
รายการข้อมูล
@endsection

@section('header')
รายการข้อมูล
@endsection

@section('css')
@endsection

@section('content')
<section class="content">
<h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
    <a href="home" class="">
         หน้าแรก
        </a> 
        /
    </span> จัดการ dashboard ติดตั้ง fttx ภายใน 3 วัน</h4>
    <div class="card ">
    <div class="d-flex justify-content-between align-items-center gap-2">
    
    <h4 class="card-header text-warning">จัดการ dashboard ติดตั้ง fttx ภายใน 3 วัน</h4>

    
    <div class="d-flex align-items-center gap-2">
    
    <form id="myForm" enctype="multipart/form-data" class="form-group d-flex align-items-center">
                    @csrf

                    <input type="number" id="year" name="year" placeholder="Enter year" min="2014" max="3000"
                    class="form-control" style="width: 200px;" />
        
        <button
                          type="button"
                          class="btn btn-dark me-4 ms-3"
                          data-bs-toggle="modal"
                          data-bs-target="#modalScrollable"
                        >
                        <i class="fas fa-question-circle"></i>
                        </button>
    </div>
</div>
        <div class="card-body">




            
                <table id="months-table" class="table table-bordered table-hover text-center">
                    <thead>
                        <tr class='bg-dark text-light'>

                            <th class="col-6 ">เดือน</th>
                            <th class="col-3">สถานะข้อมูล</th>
                            <th class="col-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>มกราคม</td>
                            <td ><div></div>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="มกราคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                    <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('มกราคม')">
                                        ลบ
                                    </button>
                               
                            </td>
                        </tr>
                        <tr>
                            <td>กุมภาพันธ์</td>
                            <td class="text-success">มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="กุมภาพันธ์" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                    <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('กุมภาพันธ์')">
                                        ลบ
                                    </button>
                            </td>
                        </tr>
                        <tr>
                            <td>มีนาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="มีนาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                    <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('มีนาคม')">
                                        ลบ
                                    </button>
                            </td>
                        </tr>
                        <tr>
                            <td>เมษายน</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="เมษายน" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                    <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('เมษายน')">
                                        ลบ
                                    </button>
                            </td>
                        </tr>
                        <tr>
                            <td>พฤษภาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="พฤษภาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('พฤษภาคม')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>มิถุนายน</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="มิถุนายน" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('มิถุนายน')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>กรกฎาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="กรกฎาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('กรกฎาคม')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>สิงหาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="สิงหาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('สิงหาคม')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>กันยายน</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="กันยายน" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('กันยายน')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>ตุลาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="ตุลาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('ตุลาคม')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>พฤศจิกายน</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="พฤศจิกายน" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('พฤศจิกายน')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>ธันวาคม</td>
                            <td>ไม่มีข้อมูล</td>
                            <td>
                                <button type="button" class="btn btn-success" value="ธันวาคม" name="month"
                                    onclick="openImportModal(value)">อัปโหลด</button>
                                     <button type="button" class="btn btn-danger" onclick="openDeleteConfirmation('ธันวาคม')">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            




            <!-- /.card-body -->




            </form>

            <!-- Modal -->
            <div class="modal fade" id="fileChoiceModal" tabindex="-1" role="dialog"
                aria-labelledby="fileChoiceModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fileChoiceModalLabel">มีข้อมูลอยู่แล้ว</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('importdata2') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="filePath" value="{{ $filePath ?? '' }}">
                                <input type="hidden" name="month" value="{{ $month ?? '' }}">
                                <input type="hidden" name="year" value="{{ $year ?? '' }}">
                                <div class="form-group">
                                    <input type="hidden" name="file_choice" value="new" id="fileChoiceNew">
                                    <p class="lead">ใช้ไฟล์ใหม่ (แทนที่ข้อมูลเดิม)</p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalScrollableTitle">คำอธิบายข้อมูลหน้าจัดการ dashboard ติดตั้ง fttx ภายใน 3 วัน</h5>
                              <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                              ></button>
                            </div>
                            <div class="modal-body text-dark">
                              <p>
                              รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                              หน้าหลัก  รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                              </p>
                              <p>
                              หมายเหตุ : รายงานระยะเวลาเฉลี่ยในการติดตั้ง ตามศูนย์บริการติดตั้ง
                              </p>
                              <p>
                              • จำนวนวงจร : จะนับเฉพาะใบคำขอที่ทำการปิดงานเรียบร้อยบนระบบ FTTxSM เท่านั้น (ไม่รวมข้อมูลใบคำขอที import มาจากสผ.และใบคำขอที่ยังไม่เคยปิดงานเรียบร้อย) ตามช่วงเวลาที่เลือก
                              </p>
                              <p>
                              • ระยะเวลาเตรียมข้อมูลรวม : ยอดรวมระยะเวลาที่ใช้ในเตรียมเอกสารของวงจรตามช่วงเวลาที่เลือก โดยนับระยะเวลาตั้งแต่วันที่สร้างคำขอ - รับชำระเงิน
                              </p>
                              <p>
                              • ระยะเวลาดำเนินการรวม : ยอดรวมระยะเวลาที่ใช้ในการติดตั้งของวงจรตามช่วงเวลาที่เลือก โดยนับระยะเวลาตั้งแต่รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้น ช่วงรอลูกค้า
                              </p>
                              <p>
                              • ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร :
                              
                              </p>
                              <p>
                              - กำหนดSDP/ODP :
                              </p>
                              <p>
                              >> กรณีส่งงานโยงสายถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงานโยงสาย หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              >> กรณีส่งงานNMSถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงาน NMS หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              - โยงสาย (ถ้าส่งงาน) : ยอดรวมจำนวนวัน นับจากวันที่ส่งงานโยงสายจนถึงส่งงาน NMS หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              - การดำเนินการของ NMS, นัดหมายและกำหนดช่าง, ปิดงาน : ยอดรวมจำนวนวัน นับจากวันที่รับงานมาดำเนินการจนถึงวันที่จ่ายงานให้งานถัดไป หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              - รอลูกค้า :
                              </p>
                              <p>
                              >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่ติดตั้ง หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่นัดหมายลูกค้า หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              - ลากสายและติดตั้ง :
                              </p>
                              <p>
                              >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ติดตั้งจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่วันนัดหมายลูกค้าจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              • รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร : ระยะเวลารวม (ช่องที่ 3) หารด้วย จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              • ร้อยละการติดตั้งภายใน 3 วัน : ร้อยละการปิดงานเรียบร้อยภายใน 3 วัน(รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้นช่วงรอลูกค้า) เมื่อเทียบกับ จำนวนวงจร (ช่องที่ 1)
                              </p>
                              <p>
                              • กรณีมีการติดตั้งวงจร แต่ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจรเท่ากับ 0.00 : ใช้ระยะเวลาในการดำเนินการเป็นระดับวินาที จึงไม่สามารถแสดงตัวเลขได้
                              </p>
                              <p>
                              • รายงานเดือนตุลา ที่มีตัวเลขติดลบในบางพื้นที่ ทางระบบกำลังดำเนินการตรวจสอบและแก้ไขค่ะ เนื่องจากมีการเลือกวันที่ติดตั้งและส่งงานไม่ถูกต้อง
                              </p>
                            </div>

                          </div>
                        </div>
                      </div>
</section>
@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentYear = new Date().toLocaleString('en-GB', { timeZone: 'Asia/Bangkok' }).split(',')[0].split('/')[2];
        document.getElementById('year').value = currentYear;  // กำหนดค่า value เป็นปีปัจจุบัน
    });
</script>

<script>
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>



<script>
    $(document).ready(function () {
        // ฟังก์ชันดึงข้อมูลเดือนจาก API
        function fetchMonths(year) {
            $.ajax({
                url: "{{ route('api.existing.months') }}", // URL ของ API
                method: "GET",
                data: {
                    year: year
                }, // ส่งค่าปีไปกับคำขอ
                success: function (response) {
                    // รีเซ็ตข้อความและลบสไตล์จาก <option> ทั้งหมด
                    $('#months-table tbody tr').each(function () {
                        $(this).find('td').eq(1).removeClass('text-success text-danger');
                        $(this).find('td').eq(1).text('ไม่มีข้อมูล');
                        $(this).find('td').eq(1).addClass('text-danger');
                        
                    });

                    // อัปเดตเดือนที่มีข้อมูล
                    response.forEach(function (item) {
                        $('#months-table tbody tr').each(function () {
                            const monthCell = $(this).find('td').eq(0);
                            if (monthCell.text() === item.month) {
                                $(this).find('td').eq(1).removeClass('text-success text-danger');
                                $(this).find('td').eq(1).text('มีข้อมูล');
                                $(this).find('td').eq(1).addClass('text-success');
                            }
                        });
                    });
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        // ดึงข้อมูลครั้งแรกเมื่อโหลดหน้า
        const initialYear = $('#year').val();
        fetchMonths(initialYear);

        // เมื่อมีการเปลี่ยนปี
        $('#year').on('change', function () {
            const selectedYear = $(this).val();
            fetchMonths(selectedYear);
        });
    });
</script>


<script>
    $(document).ready(function () {
        // ฟังก์ชันดึงข้อมูลเดือนจาก API
        function fetchMonths(year) {
            $.ajax({
                url: "{{ route('api.existing.months') }}", // URL ของ API
                method: "GET",
                data: {
                    year: year
                }, // ส่งค่าปีไปกับคำขอ
                success: function (response) {
                    // รีเซ็ตข้อความและลบสไตล์จาก <option> ทั้งหมด
                    $('#month-select option').each(function () {
                        $(this).text($(this).val()); // รีเซ็ตข้อความเป็นค่าเดิม
                        $(this).removeClass('text-success'); // ลบคลาส text-success
                    });

                    // อัปเดตเดือนที่มีข้อมูล
                    response.forEach(function (item) {
                        const option = $(`#month-select option[value="${item.month}"]`);
                        if (option.length) {
                            option.text(`${item.month} (มีข้อมูลแล้ว)`); // อัปเดตข้อความ
                            option.addClass('text-success'); // เพิ่มคลาส text-success
                        }
                    });
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        // ดึงข้อมูลครั้งแรกเมื่อโหลดหน้า
        const initialYear = $('#year').val();
        fetchMonths(initialYear);

        // เมื่อมีการเปลี่ยนปี
        $('#year').on('change', function () {
            const selectedYear = $(this).val();
            fetchMonths(selectedYear);
        });
    });

    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    let selectedMonth = ''; // เก็บเดือนที่เลือก
    let selectedYear = ''; // เก็บปีที่เลือก

    // ฟังก์ชันเปิด Modal เมื่อเลือกเดือน
    function openImportModal(month) {
    Swal.fire({
        title: 'กรุณาเลือกไฟล์ที่อัพโหลด',
        html: `
            <div class="row">
                <input class="form-control" type="file" id="import_file" name="import_file">
            </div>
        `,
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Submit',
        customClass: {
            confirmButton: 'btn-success' // เพิ่มคลาส Bootstrap สีเขียว

        },
        preConfirm: () => {
            const importFile = Swal.getPopup().querySelector('#import_file').files[0];
            if (!importFile) {
                Swal.showValidationMessage('Please choose a file to import.');
            }
            return {
                month,
                importFile
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const {
                month,
                importFile
            } = result.value;
            submitImportData(month, importFile);
        }
    });
}

    


    // ฟังก์ชันส่งข้อมูลไปยังเซิร์ฟเวอร์
    function submitImportData(selectedMonth, importFile) {
        const year = document.getElementById('year').value;

        if (!importFile) {
            alert('Please choose a file to import.');
            return;
        }

        // สร้าง FormData object
        const formData = new FormData();
        formData.append('month', selectedMonth);
        formData.append('year', year);
        formData.append('import_file', importFile);




        fetch('/importdata', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.showModal) {
                    // ตั้งค่าข้อมูลในฟอร์ม
                    $('#fileChoiceModal #fileChoiceNew').val('new'); // ตั้งค่า file_choice เป็น 'new'
                    $('#fileChoiceModal input[name="filePath"]').val(data.filePath);
                    $('#fileChoiceModal input[name="month"]').val(data.month);
                    $('#fileChoiceModal input[name="year"]').val(data.year);

                    // เปิด Modal
                    $('#fileChoiceModal').modal('show');
                } else if (data.status === 'success') {
                    // แสดง SweetAlert สำหรับสถานะ success
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: data.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = data.redirect_url; // ทำการ redirect ไปยัง URL ที่กำหนด
                    });
                } else if (data.status === 'error') {
                    // แสดง SweetAlert สำหรับสถานะ error
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการนำเข้าไฟล์',
                        text: data.message,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                // แสดงข้อผิดพลาดในกรณีที่เกิดปัญหาในการเชื่อมต่อกับเซิร์ฟเวอร์
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                    confirmButtonText: 'OK'
                });
            });

    }
</script>

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
    // ฟังก์ชันเปิด Modal เมื่อเลือกเดือน
    // ฟังก์ชันเปิด Modal เมื่อเลือกเดือน
    function openDeleteConfirmation(month) {
        const year = document.getElementById('year').value;

        Swal.fire({
            title: 'ต้องการลบข้อมูล?',
            text: `คุณต้องการลบข้อมูลใน เดือน ${month} ปี ${year}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งทั้งปี (year) และเดือน (month) ไปยังฟังก์ชัน deleteData
                deleteData(year, month);

            }
        });
    }



    // ฟังก์ชันลบข้อมูล
    function deleteData(year, month) {
        // ส่งคำขอ DELETE ไปยังเซิร์ฟเวอร์
        fetch(`/delete/${year},${month}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                // ถ้าลบสำเร็จ
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: `ลบข้อมูลในเดือน ${month} ปี ${year} แล้ว`,
                    confirmButtonText: 'ตกลง',
         
                }).then(() => {
                    // หลังจากแสดงข้อความเสร็จ จะรีโหลดหน้าใหม่
                    location.reload();
                });
            })

            .catch(error => {
                // ถ้ามีข้อผิดพลาด
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong while deleting the data.',
                });
                console.error('Error:', error);
            });
    }
</script>



@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาดในการนำเข้าไฟล์',
            text: {!! json_encode(session('error')) !!},
            confirmButtonText: 'ตกลง'
        });
    </script>
@endif
@endsection