@extends('admins.index')

@section('title')
    รายการข้อมูล
@endsection

@section('header')
    รายการข้อมูล
@endsection

@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
                                                <select class="form-control" name="month">
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
                                                @error('month')
                                                    <p class="text-danger my-2">
                                                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                                                    </p>
                                                @enderror
                                            </td>


                                            <td>
                                                <div class="custom-file">
                                                    <input type="file" class="form-control" name="import_file">
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
        <div class="modal fade" id="fileChoiceModal" tabindex="-1" role="dialog" aria-labelledby="fileChoiceModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileChoiceModalLabel">มีข้อมูลอยู่ในเดือนและปีดังกล่าวแล้ว</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('importdata2') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="filePath" value="{{ $filePath ?? '' }}">
                            <input type="hidden" name="month" value="{{ $month ?? ''}}">
                            <input type="hidden" name="year" value="{{ $year ?? ''}}">
                            <div class="form-group">
                                <input type="hidden" name="file_choice" value="new" id="fileChoiceNew">
                                <p class="lead" >ใช้ไฟล์ใหม่ (แทนที่ข้อมูลเดิม)</p>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
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
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
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
    @if(isset($showModal) && $showModal)
        $(document).ready(function () {
            $('#fileChoiceModal').modal('show');
        });
    @endif
</script>
@endsection
