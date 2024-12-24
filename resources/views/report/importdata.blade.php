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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark mt-2">
                    <div class="card-header">
                        <h3 class="card-title">อัพโหลด</h3>

                        <div class="card-tools d-flex align-items-center">
                            <form action="{{ url('importdata') }}" method="POST" enctype="multipart/form-data"
                                class="form-group d-flex align-items-center">
                                @csrf
                                <input type="number" id="year" name="year" min="2014" max="3000" value="2024"
                                    class="form-control me-2" style="width: 200px;">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                        </div>

                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="example2" class="table table-bordered">
                            <thead class="text-center">
                                <tr>

                                    <th class="col-4">ปี</th>
                                    <th class="col-4">เดือน</th>
                                    <th class="col-4">อัพโหลด</th>
                                </tr>
                            </thead>
                            <tbody class="align-items-center">

                                <tr>


                                    <td>
                                        <select id="month-select" class="form-control" name="month">
                                            <option value="เลือกเดือน" disabled selected>เลือกเดือน</option>
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
                                        @error('month')
                                            <p class="text-danger my-2">
                                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </td>


                                    <td>
                                        <div class="mb-3">
                                            <div class="custom-file">
                                                <input type="file" id="import_file" class="custom-file-input"
                                                    name="import_file">
                                                <label class="custom-file-label" for="import_file">เลือกไฟล์...</label>
                                            </div>
                                            @error('import_file')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-12 mb-3 text-center">
                            <a href="/listnewsfeed" class="btn bg-danger">Cancel</a>
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>

                        <script>
                            // Update the file input label with the selected file name
                            document.querySelector('.custom-file-input').addEventListener('change', function (e) {
                                var fileName = e.target.files[0]?.name || "Choose file";
                                e.target.nextElementSibling.textContent = fileName;
                            });
                        </script>

                        <div class="col-md-12 mt-1">

                            <table id="month-select" name="month" class="table table-bordered">
                                <table id="months-table" class="table table-bordered text-center">
                                    <thead>
                                        <tr class='bg-dark'>

                                            <th class="col-6 ">เดือน</th>
                                            <th class="col-3">สถานะข้อมูล</th>
                                            <th class="col-3">Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody >
                                        <tr>
                                            <td>มกราคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>
                                            <button type="button" class="btn btn-primary" value="มกราคม" name="month">มกราคม</button>
                                                <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>กุมภาพันธ์</td>
                                            <td class="text-success">มีข้อมูล</td>
                                            <td><button type="button" value="กุมภาพันธ์" name="month" onclick="showUploadAlert(value)">Click Me</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>มีนาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>เมษายน</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>พฤษภาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>มิถุนายน</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>กรกฎาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>สิงหาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>กันยายน</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>ตุลาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>พฤศจิกายน</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                        <tr>
                                            <td>ธันวาคม</td>
                                            <td>ไม่มีข้อมูล</td>
                                            <td>ปุ่ม</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </table>


                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fileChoiceModal" tabindex="-1" role="dialog" aria-labelledby="fileChoiceModalLabel"
        aria-hidden="true">
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
    <!-- /.container-fluid -->
</section>
@endsection

@section('script')
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
    // เปิด Modal อัตโนมัติถ้าตัวแปร showModal เป็นจริง
    @if (isset($showModal) && $showModal)
        $(document).ready(function () {
            $('#fileChoiceModal').modal('show');
        });
    @endif
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
                    });

                    // อัปเดตเดือนที่มีข้อมูล
                    response.forEach(function (item) {
                        $('#months-table tbody tr').each(function () {
                            const monthCell = $(this).find('td').eq(0);
                            if (monthCell.text() === item.month) {
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

    function showUploadAlert(month) {
            Swal.fire({
                title: 'อัพโหลดไฟล์',
                text: `คุณต้องการอัพโหลดไฟล์สำหรับ ${month} หรือไม่?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, อัพโหลด!',
                
                didOpen: () => {
                    // หลังจากที่ Swal ถูกแสดง เราจะเพิ่ม listener สำหรับการเลือกไฟล์
                    document.getElementById('import_file').addEventListener('change', (event) => {
                        // แสดงชื่อไฟล์ที่เลือกใน label
                        const fileName = event.target.files[0] ? event.target.files[0].name : 'ยังไม่ได้เลือกไฟล์';
                        document.querySelector('.custom-file-label').textContent = fileName;
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // หลังจากการยืนยันการอัพโหลด สามารถทำอะไรได้ที่นี่
                    alert('ไฟล์พร้อมสำหรับการอัพโหลด');
                }
            });
        }



        function logTime(month) {
            const currentTime = new Date();
            console.log(`กดปุ่ม ${month} เวลา: ${currentTime}`);
        }
     
    function showValue(button) {
        alert('Button value: ' + button.value);
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