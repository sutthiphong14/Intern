@extends('admins.index')
@section('title')
    รายการหมวดหมู่
@endsection
@section('header')
    รายการหมวดหมู่
@endsection

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning mt-3 mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title col-5">รายการหมวดหมู่</h3>
                        <div class="input-group col-4">
                            <form action="{{ route('categories.search') }}" method="GET" class="d-flex w-100">
                                <input type="text" name="query" class="form-control" placeholder="ค้นหาหมวดหมู่..." value="{{ request('query') }}">
                                <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
                            </form>
                        </div>
                        
                        <a href="{{ route('categories.create') }}" class="btn bg-success col-2">
                            <i class="d-flex justify-content-end"></i> เพิ่มหมวดหมู่
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class='text-center'>
                                <tr>
                                    
                                    <th class='col-7'>ชื่อหมวดหมู่</th>
                                    <th class='col-3'>การดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    
                                    <td class="text-center">{{ $category->name }}</td>
                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm" style="margin-right: 10px;">
                                            แก้ไข
                                        </a>
                                    
                                        <!-- Delete Button with Confirmation -->
                                        <form action="{{ route('categories.delete', $category->id) }}" method="POST" 
                                            onsubmit="return confirm('Are you sure?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                ลบ
                                            </button>
                                        </form>
                                    </td>                                                                          
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(function () {
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                let url = this.getAttribute('data-url');
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "ข้อมูลจะถูกลบและไม่สามารถกู้คืนได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบเลย!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
@endsection