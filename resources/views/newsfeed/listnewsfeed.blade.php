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

    <div class="card-header d-flex justify-content-between align-items-center ">
        <h3 class="card-title col-5">รายชื่อผู้ใช้ </h3>





        <a href="insertnewsfeed" class="btn bg-success col-2">
            <i class="d-flex justify-content-end "></i> เพิ่มเอกสาร
        </a>
    </div>

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example2" class="table table-hover ">
            <thead class='text-center col-12 bg-dark'>
                <tr>

                    <th class='col-3'>ชื่อข่าว</th>
                    <th class='col-4'>คำอธิบาย</th>
                    <th class='col-2'>เวลาลงข้อมูล</th>
                    <th class='col-3'>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class='text-center'>

                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                        <td class='align-items-center text-center'>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Toggle news status button -->
                                    <button onclick="changeNewsStatus({{ $item->id }})"
                                        class="dropdown-item {{ $item->status ? 'text-success' : 'text-dark' }}">
                                        <i class="{{ $item->status ? 'fas fa-eye-slash' : 'far fa-eye' }} me-1"></i>
                                        {{ $item->status ? 'แสดง' : 'ซ่อน' }}
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


</div>
<!-- /.card -->


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
                        button.className = "align-items-center";
                        button.innerHTML = '<i class="fas fa-eye-slash"></i> ซ่อน';
                    } else {
                        button.className = "align-items-center";
                        button.innerHTML = '<i class="far fa-eye"></i> แสดง';
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