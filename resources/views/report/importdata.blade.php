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
                                <form id="myForm" enctype="multipart/form-data"
                                    class="form-group d-flex align-items-center">
                                    @csrf

                                    <input type="number" id="year" name="year" placeholder="Enter year"
                                        min="2014" max="3000" value="2024" class="form-control"
                                        style="width: 200px;" />

                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>

                            </div>

                        </div>


                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="example2" class="table table-bordered">
                                {{-- <thead class="text-center">
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
                        </script> --}}

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

                                            <tbody>
                                                <tr>
                                                    <td>มกราคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" value="มกราคม"
                                                            name="month" onclick="openImportModal(value)">มกราคม</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">ลบ</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>กุมภาพันธ์</td>
                                                    <td class="text-success">มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="กุมภาพันธ์" name="month"
                                                            onclick="openImportModal(value)">คลิกเพื่ออัปโหลด</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>มีนาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="มีนาคม" name="month"
                                                            onclick="openImportModal(value)">มีนาคม</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>เมษายน</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="เมษายน" name="month"
                                                            onclick="openImportModal(value)">เมษายน</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>พฤษภาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="พฤษภาคม" name="month"
                                                            onclick="openImportModal(value)">พฤษภาคม</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>มิถุนายน</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="มิถุนายน" name="month"
                                                            onclick="openImportModal(value)">มิถุนายน</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>กรกฎาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="กรกฎาคม" name="month"
                                                            onclick="openImportModal(value)">กรกฎาคม</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>สิงหาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="สิงหาคม" name="month"
                                                            onclick="openImportModal(value)">สิงหาคม</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>กันยายน</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="กันยายน" name="month"
                                                            onclick="openImportModal(value)">กันยายน</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ตุลาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="ตุลาคม" name="month"
                                                            onclick="openImportModal(value)">ตุลาคม</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>พฤศจิกายน</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="พฤศจิกายน" name="month"
                                                            onclick="openImportModal(value)">พฤศจิกายน</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ธันวาคม</td>
                                                    <td>ไม่มีข้อมูล</td>
                                                    <td>
                                                        <button type="button" value="ธันวาคม" name="month"
                                                            onclick="openImportModal(value)">ธันวาคม</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </table>


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


        </form>

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
        $(function() {
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
        $(document).ready(function() {
            // ฟังก์ชันดึงข้อมูลเดือนจาก API
            function fetchMonths(year) {
                $.ajax({
                    url: "{{ route('api.existing.months') }}", // URL ของ API
                    method: "GET",
                    data: {
                        year: year
                    }, // ส่งค่าปีไปกับคำขอ
                    success: function(response) {
                        // รีเซ็ตข้อความและลบสไตล์จาก <option> ทั้งหมด
                        $('#months-table tbody tr').each(function() {
                            $(this).find('td').eq(1).removeClass('text-success text-danger');
                            $(this).find('td').eq(1).text('ไม่มีข้อมูล');
                        });

                        // อัปเดตเดือนที่มีข้อมูล
                        response.forEach(function(item) {
                            $('#months-table tbody tr').each(function() {
                                const monthCell = $(this).find('td').eq(0);
                                if (monthCell.text() === item.month) {
                                    $(this).find('td').eq(1).text('มีข้อมูล');
                                    $(this).find('td').eq(1).addClass('text-success');
                                }
                            });
                        });
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // ดึงข้อมูลครั้งแรกเมื่อโหลดหน้า
            const initialYear = $('#year').val();
            fetchMonths(initialYear);

            // เมื่อมีการเปลี่ยนปี
            $('#year').on('change', function() {
                const selectedYear = $(this).val();
                fetchMonths(selectedYear);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // ฟังก์ชันดึงข้อมูลเดือนจาก API
            function fetchMonths(year) {
                $.ajax({
                    url: "{{ route('api.existing.months') }}", // URL ของ API
                    method: "GET",
                    data: {
                        year: year
                    }, // ส่งค่าปีไปกับคำขอ
                    success: function(response) {
                        // รีเซ็ตข้อความและลบสไตล์จาก <option> ทั้งหมด
                        $('#month-select option').each(function() {
                            $(this).text($(this).val()); // รีเซ็ตข้อความเป็นค่าเดิม
                            $(this).removeClass('text-success'); // ลบคลาส text-success
                        });

                        // อัปเดตเดือนที่มีข้อมูล
                        response.forEach(function(item) {
                            const option = $(`#month-select option[value="${item.month}"]`);
                            if (option.length) {
                                option.text(`${item.month} (มีข้อมูลแล้ว)`); // อัปเดตข้อความ
                                option.addClass('text-success'); // เพิ่มคลาส text-success
                            }
                        });
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // ดึงข้อมูลครั้งแรกเมื่อโหลดหน้า
            const initialYear = $('#year').val();
            fetchMonths(initialYear);

            // เมื่อมีการเปลี่ยนปี
            $('#year').on('change', function() {
                const selectedYear = $(this).val();
                fetchMonths(selectedYear);
            });
        });

        $(function() {
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
                title: 'Confirm Import',
                html: `
            <label for="import_file">Choose File to Import:</label>
            <input type="file" id="import_file" name="import_file"  class="swal2-input">
        `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
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
                    }

                    if (data.status) {
                        // แสดง SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.status,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = data.redirect_url; // ทำการ redirect ไปยัง URL ที่กำหนด
                        });
                    }

                    
                })

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
