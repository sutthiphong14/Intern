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
<div class="card card-warning mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <!-- หัวข้อ -->
        <h3 class="card-header">รายชื่อผู้ใช้</h3>

        <div class="d-flex align-items-center gap-2">
            <!-- เพิ่มฟอร์มค้นหา -->
            <form action="{{ route('news.search') }}" method="GET" class="d-flex w-200">
                <input type="text" name="query" class="form-control" placeholder="ค้นหาชื่อข่าว..."
                    value="{{ request('query') }}">
                <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
            </form>
            
            <a href="insertnewsfeed" class="btn bg-success col-4 me-4">
                <i class="d-flex justify-content-end"></i> เพิ่มเอกสาร
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="text-center bg-dark">
                    <tr>
                        <th class="col-3">ชื่อข่าว</th>
                        <th class="col-4">คำอธิบาย</th>
                        <th class="col-1">เวลาลงข้อมูล</th>
                        <th class="col-1">สถานะข้อมูล</th>
                        <th class="col-3">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 text-center">
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                            <td>{{ $item->status == 1 ? 'แสดง' : 'ซ่อน' }}</td>
                            <td>
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
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('ต้องการลบข้อมูล {{ $item->name }} หรือไม่?')">
                                                <i class="bx bx-trash me-1"></i> ลบ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">ไม่พบข้อมูล</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center align-items-center me-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                @if ($data->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->appends(request()->query())->url(1) }}">
                            <i class="tf-icon bx bx-chevrons-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->appends(request()->query())->previousPageUrl() }}">
                            <i class="tf-icon bx bx-chevron-left"></i>
                        </a>
                    </li>
                @endif

                @foreach ($data->appends(request()->query())->getUrlRange(1, $data->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($data->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->appends(request()->query())->nextPageUrl() }}">
                            <i class="tf-icon bx bx-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ $data->appends(request()->query())->url($data->lastPage()) }}">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevron-right"></i></span>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
<!-- /.card -->


@endsection

@section('script')
<script>
    function changeNewsStatus(id) {
        fetch(`/news/status/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (response.ok) {
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

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!',
        text: '{{ session('success') }}',
        confirmButtonText: 'ตกลง'
    });
</script>
@endif
@endsection