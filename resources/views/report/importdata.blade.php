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
                    <div class="card card-warning mt-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">เพิ่มเอกสาร</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">


                            <form action="{{ url('importdata') }}" method="POST" enctype="multipart/form-data"
                                class="form-group">
                                @csrf
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
                                                <input type="number" id="year" name="year" min="2014"
                                                    max="3000" value="2024" class="form-control">
                                            </td>
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
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="import_file">
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
                            </form>

                            <script>
                                // Update the file input label with the selected file name
                                document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                                    var fileName = e.target.files[0]?.name || "Choose file";
                                    e.target.nextElementSibling.textContent = fileName;
                                });
                            </script>
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
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
            $(document).ready(function() {
                $('#fileChoiceModal').modal('show');
            });
        @endif
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
