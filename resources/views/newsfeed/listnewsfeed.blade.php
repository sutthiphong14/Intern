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
                                <form method="GET" action="{{ route('search') }}" class="d-flex w-100">
                                    <input type="text" name="search" value="{{ request()->query('search') }}"
                                        class="form-control" placeholder="Search by Name">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-dark">Search</button>
                                    </span>
                                </form>
                            </div>



                            <a href="insertnewsfeed" class="btn bg-success col-2">
                                <i class="d-flex justify-content-end "></i> เพิ่มเอกสาร
                            </a>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover ">
                                <thead class='text-center col-12 '>
                                    <tr>
                                        <th class='col-1 '>ID</th>
                                        <th class='col-3'>ชื่อข่าว</th>
                                        <th class='col-4'>คำอธิบาย</th>
                                        <th class='col-1'>เวลาลงข้อมูล</th>
                                        <th class='col-3'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                                            <td class='align-items-center text-center'>
                                                <button onclick="changeNewsStatus({{ $item->id }})"
                                                    class="btn {{ $item->status ? 'btn-primary' : 'btn-secondary' }} align-items-center">
                                                    <i class="{{ $item->status ? 'fas fa-eye-slash' : 'far fa-eye' }}"></i>
                                                    {{ $item->status ? 'แสดง' : 'ซ่อน' }}
                                                </button>
                                                <a href="{{ route('editnews', $item->id) }}"
                                                    class="btn btn-warning align-items-center">
                                                    <i class="fas fa-edit text-light"></i> แก้ไข
                                                </a>
                                                <a href="{{ route('deletenews', $item->id) }}"
                                                    class="btn btn-danger align-items-center"
                                                    onclick="return confirm('ต้องการลบข้อมูล {{ $item->name }} หรือไม่')">
                                                    <i class="fas fa-trash"></i> ลบ
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No results found</td>
                                        </tr>
                                    @endforelse
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
    
    <!-- Page specific script -->
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
        function changeNewsStatus(id) {
            fetch(`/changenews/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ค้นหาและอัปเดตปุ่มในแถวที่เกี่ยวข้อง
                        const button = document.querySelector(`button[onclick="changeNewsStatus(${id})"]`);
                        if (data.status) {
                            button.className = "btn btn-primary align-items-center";
                            button.innerHTML = '<i class="fas fa-eye-slash"></i> Hide';
                        } else {
                            button.className = "btn btn-secondary align-items-center";
                            button.innerHTML = '<i class="far fa-eye"></i> Show';
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง');
                });
        }
    </script>
@endsection
