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
                <div class="card card-warning mt-2 ">

                    <!-- /.card-header -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">แ้กไขสิทธ์การใช้งานระบบ +</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ชื่อผู้ใช้</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        placeholder="Enter Username">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">สิทธิ์การใช้งาน</label>
                                </div>

                                <div class="table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead class="text-center ">
                                            <tr>
                                                <th class='col-4 bg-dark'>สิทธิ์</th>
                                                <th class='col-7 bg-dark'>คำอธิบาย</th>
                                                <th class='col-1 bg-dark'>อนุญาติ</th>


                                            </tr>
                                        </thead>
                                        <tbody class='text-start align-items-center'>
                                            <tr>
                                                <td>จัดการผู้ใช้งานระบบ</td>
                                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข
                                                    ให้สิทธิ์การใช้งานในระบบต่างๆแก่ผู้ใช้งานระบบ</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="customSwitch1" style="transform: scale(2);">
                                                            <label class="form-check-label" for="customSwitch1"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>จัดการหน้าแดชบอร์ด</td>
                                                <td>สิทธิ์ในการ อัพโหลด ลบ แก้ไข หน้าแดชบอร์ด</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="customSwitch1" style="transform: scale(2);">
                                                            <label class="form-check-label" for="customSwitch1"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>จัดการแหล่งป้อนข่าว</td>
                                                <td>สิทธิ์ในการ เพิ่ม ลบ แก้ไข เปิดปิดการแสดงผลของหน้าฟีดข่าว</td>
                                                <td class='text-center'>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="customSwitch1" style="transform: scale(2);">
                                                            <label class="form-check-label" for="customSwitch1"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer align-items-center text-center">
                                <button type="submit" class="btn btn-danger ">ยกเลิก</button>
                                <button type="submit" class="btn btn-success">ยืนยัน</button>
                            
                        </form>
                    </div>

                    </tbody>

                    </table>




                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
@endsection

@section('script')
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(function () {
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

@endsection