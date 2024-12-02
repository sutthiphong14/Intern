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
                <div class="card card-warning mt-3 mb-3 ">

                    <div class="card-header d-flex justify-content-between align-items-center ">
                        <h3 class="card-title col-5">รายชื่อผู้ใช้ </h3>

                        <div class="input-group col-4">
                            <input type="text" class="form-control">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-dark">Search</button>
                            </span>
                        </div>



                        <a href="insertusers" class="btn bg-success col-2">
                            <i class="d-flex justify-content-end "></i> เพิ่มผู้ใช้งาน
                        </a>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover ">
                            <thead class='text-center col-12 '>
                                <tr>
                                    <th class='col-1 '>ID</th>
                                    <th class='col-3'>Name</th>
                                    <th class='col-4'>Description</th>
                                    <th class='col-1'>permission</th>
                                    <th class='col-3'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>id1</td>
                                    <td>name1</td>
                                    <td>------------</td>
                                    <td>Admin</td>
                                    <td class='align-items-center text-center'>
                                        <a href="permissionsusers" class="btn btn-primary align-items-center">
                                            <i class="far fa-eye"></i> สิทธิ์การใช้งาน
                                        </a>

                                        <a class="btn btn-warning align-items-center">
                                            <i class="fas fa-edit text-light"></i> แก้ไข
                                        </a>
                                        <a class="btn btn-danger align-items-center">
                                            <i class="fas fa-trash"></i> ลบ
                                        </a>

                                    </td>
                                </tr>
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