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


<div class="card card-warning mt-3 mb-3 ">

    <div class="d-flex justify-content-between align-items-center gap-2">
        <h3 class="card-header col-5">จัดการประชาสัมพันธ์ </h3>
        <div class="d-flex align-items-center gap-2">





        <a href="insertnewsfeed" class="btn bg-success">
            <i class="d-flex justify-content-end "></i> เพิ่มเอกสาร
        </a>
        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
            <i class="fas fa-question-circle"></i>
        </button>
        </div>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example2" class="table table-hover ">
            <thead class='text-center col-12 bg-dark'>
                <tr>

                    <th class='col-2'>ชื่อข่าว</th>
                    <th class='col-5 '>คำอธิบาย</th>
                    <th class='col-1'>สถานะข้อมูล</th>
                    <th class='col-2'>เวลาลงข้อมูล</th>
                    <th class='col-1'>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="text-center">
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->status == 1 ? 'แสดง' : 'ซ่อน' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        <td class="align-items-center text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Toggle news status button -->
                                    <button onclick="changeNewsStatus({{ $item->id }})"
                                        class="dropdown-item {{ $item->status ? 'text-dark' : 'text-dark' }}">
                                        <i class="{{ $item->status ? 'fas fa-eye-slash' : 'far fa-eye' }} me-1"></i>
                                        {{ $item->status ? 'ซ่อน' : 'แสดง' }}
                                    </button>

                                    <!-- Edit link -->
                                    <a class="dropdown-item" href="{{ route('editnews', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> แก้ไข
                                    </a>

                                    <!-- Delete form -->
                                    <form action="{{ route('deletenews', $item->id) }}" method="POST"
                                        class="d-inline delete-form"
                                        onsubmit="return confirm('ต้องการลบข้อมูล {{ $item->name }} หรือไม่?')">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('deletenews', $item->id) }}"
                                            class="dropdown-item text-danger align-items-center"
                                            onclick="return confirm('ต้องการลบข้อมูล {{ $item->name }} หรือไม่')">
                                            <i class="fas fa-trash"></i> ลบ
                                        </a>
                                    </form>
                                </div>
                            </div>
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


    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center me-4">
        <nav aria-label="Page navigation ">
            <ul class="pagination">
                <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}"><i
                            class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
                <li class="page-item {{ $data->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $data->previousPageUrl() }}"><i
                            class="tf-icon bx bx-chevron-left"></i></a>
                </li>
                @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}"><i
                            class="tf-icon bx bx-chevron-right"></i></a>
                </li>
                <li class="page-item {{ $data->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $data->nextPageUrl() }}"><i
                            class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>


</div>
<!-- /.card -->



<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalScrollableTitle">การใช้งานหน้าจัดการข่าวประชาสัมพันธ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                    <p>
                        วิธีเพิ่มข้อมูล
                    </p>
                    <p>
                        ------------
                    </p>
                    
                </div>

            </div>
        </div>
    </div>


@endsection

@section('script')

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


<script>
    function changeNewsStatus(id) {
        // ส่งคำขอไปยังเส้นทาง API ผ่าน AJAX
        fetch(`/news/status/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // ป้องกัน CSRF
            },
            body: JSON.stringify({})
        })
            .then(response => {
                if (response.ok) {
                    // รีเฟรชหน้าเว็บเมื่อคำขอสำเร็จ
                    location.reload();
                } else {
                    alert('เกิดข้อผิดพลาดในการเปลี่ยนสถานะ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
            });
    }
</script>
@endsection