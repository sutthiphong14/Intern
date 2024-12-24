@extends('admins.index')

@section('title')
    รายการข้อมูล
@endsection

@section('header')
ส่งออกเอกสาร
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
                            <h3 class="card-title">ส่งออกเอกสาร การติดตั้ง FTTx ได้ภายใน 3 วัน </h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">


                            <form action="{{ route('export') }}" method="get" enctype="multipart/form-data"
                                class="form-group">
                                @csrf
                                <table id="example2" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr>

                                            <th class="col-2">ปี</th>
                                            <th class="col-2">เดือน</th>
                                            
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


                                           
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-12 mb-3 text-center">
                                    <a href="{{ url()->previous() }}" class="btn bg-danger">Cancel</a>
                                    <input type="submit" class="btn btn-success" value="Export">
                                </div>
                            </form>

                            
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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
    $(document).ready(function() {
        const initialYear = $('#year').val(); // เก็บค่าปีเริ่มต้น

        // ฟังก์ชันดึงข้อมูลเดือนจาก API
        function fetchMonths(year) {
            $.ajax({
                url: "{{ route('api.existing.months') }}", // URL ของ API
                method: "GET",
                data: { year: year }, // ส่งค่าปีไปกับคำขอ
                success: function(response) {
                    // ตรวจสอบว่ามีข้อมูลหรือไม่
                    if (response.length === 0) {
                        // แจ้งเตือนผู้ใช้ด้วย SweetAlert
                        Swal.fire({
                            icon: 'warning',
                            title: 'ไม่มีข้อมูล',
                            text: `ไม่มีข้อมูลสำหรับปี ${year}`,
                            confirmButtonText: 'ตกลง'
                        }).then(() => {
                            // รีเซ็ตค่าปีกลับไปยังค่าปีเริ่มต้น
                            $('#year').val(initialYear).trigger('change');
                        });

                        return;
                    }

                    
                    // ลบเดือนที่ไม่มีข้อมูลออก
                    const monthsWithData = response.map(item => item.month);
                    $('#month-select option').each(function() {
                        const monthValue = $(this).val();
                        if (!monthsWithData.includes(monthValue)) {
                            $(this).remove();
                        }
                    });
                },
                error: function(error) {
                    console.error("Error fetching data:", error);
                    // แจ้งข้อผิดพลาดด้วย SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถดึงข้อมูลได้ โปรดลองอีกครั้ง',
                        confirmButtonText: 'ตกลง'
                    });
                }
            });
        }

        // ดึงข้อมูลครั้งแรกเมื่อโหลดหน้า
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
