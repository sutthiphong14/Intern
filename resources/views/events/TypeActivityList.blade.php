@extends('admins.index')
@section('css')
<style>
  /* กำหนดความสูงของ modal ให้เล็กลง */
  #addTypeModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #addTypeModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }

    /* กำหนดความสูงของ modal ให้เล็กลง */
  #editTypeModal .modal-dialog {
        max-width: 400px;
        /* ปรับความกว้างของ modal */
        height: auto;
        /* ความสูงปรับตามเนื้อหา */
    }

    #editTypeModal .modal-content {
        height: auto;
        /* ความสูงของ content ปรับตามเนื้อหาภายใน */
    }editTypeModal

</style>


@endsection
@section('content')




    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / ข้อมูลกิจกรรม
    </h4>
    <div class="content-wrapper">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">ข้อมูลกิจกรรม</h3>
                <div class="d-flex align-items-center gap-2">
                    
                    <div class="d-flex align-items-center gap-2">
                    @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false))
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addTypeModal">เพิ่มกิจกรรม
                        </button>
                    @endif
                        

                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>
            </div>



            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr class="bg-dark text-center align-center">
                            @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) || (Auth::user()->permission['view_fttx'] ?? false ))
                                <th rowspan="2">ข้อมูล สถิติ</th>
                            @endif
                                <th rowspan="2">ชื่อกิจกรรม</th>
                                <th colspan="5">FTTX</th>
                                <th colspan="4">SIM my</th>
                                <th colspan="2">Ict Solution</th>
                                @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) || (Auth::user()->permission['form_event'] ?? false ) || (Auth::user()->permission['view_customer'] ?? false))
                                <th rowspan="2">ข้อมูลลูกค้า</th>
                                @endif
                                @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false))
                                <th rowspan="2">เครื่องมือ</th>
                                @endif
                            </tr>
                            <tr class="bg-dark text-center">
                                <th>new</th>
                                <th>ติดตั้งเอง</th>
                                <th>จ้างผู้รับเหมา</th>
                                <th>ปรับโปรโมชั่น</th>
                                <th>ลูกค้าย้ายค่าย</th>
                                <th>ลูกค้าใหม่</th>
                                <th>ลูกค้า (ย้ายค่าย)</th>
                                <th>จำนวน (ราย)</th>
                                <th>ยอดเงิน</th>
                                <th>จำนวน (ราย)</th>
                                <th>รายได้</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @if (!empty($sumByType) && count($sumByType) > 0)
                                                @foreach ($sumByType as $typeId => $data)
                                                                    @php
                                                                        // กรองเฉพาะกิจกรรมที่ตรงกับ typeId ปัจจุบัน
                                                                        $activities = collect($typeActivities)->where('type_id', $typeId);
                                                                    @endphp
                                                                    @foreach ($activities as $row)
                                                                        <tr>
                                                                        @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) || (Auth::user()->permission['view_fttx'] ?? false ))                                                                        <td>
                                                                        <a href="{{ route('event_department', $typeId) }}" class="btn btn-warning" target="_blank" rel="noopener noreferrer">
                                                                            <i class="fas fa-search"></i>
                                                                        </a>
                                                                    </td>
                                                                    @endif
                                                                            <td>{{ $row->type_name }}</td>
                                                                            <td>{{ ($data['selfInstall'] ?? 0) + ($data['hireInstall'] ?? 0) }}</td>
                                                                            <td>{{ $data['selfInstall'] ?? 0 }}</td>
                                                                            <td>{{ $data['hireInstall'] ?? 0 }}</td>
                                                                            <td>{{ $data['adjust'] ?? 0 }}</td>
                                                                            <td>{{ $data['fttxmove'] ?? 0 }}</td>
                                                                            <td>{{ $data['new'] ?? 0 }}</td>
                                                                            <td>{{ $data['move'] ?? 0 }}</td>
                                                                            <td>{{ $data['count'] ?? 0 }}</td>
                                                                            <td>{{ $data['price'] ?? 0 }}</td>
                                                                            <td>{{ $data['ictCount'] ?? 0 }}</td>
                                                                            <td>{{ $data['ictIncome'] ?? 0 }}</td>
                                                                            @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) || (Auth::user()->permission['form_event'] ?? false ) || (Auth::user()->permission['view_customer'] ?? false))
                                                                            <td>
                                                                                <a href="{{ route('event_customer', $row->type_id) }}"
                                                                                    class="btn btn-success "><i class="fas fa-search"></i></a>
                                                                            </td>
                                                                            @endif
                                                                            
                                                                            @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false))
                                                                            <td>
         <div class="dropdown-menu-start">
        <button type="button" class="btn btn-light btn-sm p-1 dropdown-toggle hide-arrow"
            data-bs-toggle="dropdown">
            <i class="bx bx-dots-vertical-rounded fs-5"></i>
        </button>
        <ul class="dropdown-menu shadow border-0 rounded">
        <li>
                <a href="{{ route('service_list', $row->type_id) }}" class="dropdown-item text-dark">
                    <i class="fas fa-tools"></i> จัดการบริการ
                </a>
            </li>
            <li>
                <button class="dropdown-item text-dark editBtn"
                    data-id="{{ $row->type_id }}" data-name="{{ $row->type_name }}"
                    data-bs-toggle="modal" data-bs-target="#editTypeModal">
                    <i class="bx bx-edit"></i> แก้ไขชื่อกิจกรรม
                </button>
            </li>
            <li>
                <form action="{{ route('type_delete', $row->type_id) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger deleteBtn"
                        id="deleteBtn{{ $row->type_id }}">
                        <i class="bx bx-trash"></i> ลบกิจกรรม
                    </button>
                </form>
            </li>
            
        </ul>
    </div>
</td>
@endif

                                                                        </tr>
                                                                    @endforeach
                                                @endforeach
                            @else
                                <tr>
                                    <td colspan="15" class="text-center text-danger">
                                        ไม่มีข้อมูลกิจกรรมในขณะนี้
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>



            {{-- modal add --}}
            <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTypeModalLabel">เพิ่มกิจกรรม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addTypeForm" action="{{ route('type_insert') }}" method="POST">
                                @csrf
                                <div class="mb-3">


                                    <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
                                    <input type="text" class="form-control" id="type_name" name="type_name" required>
                                    <input type="hidden" name="created_at" value="{{ \Carbon\Carbon::now() }}">
                                    <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Edit -->
            <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTypeModalLabel">แก้ไขกิจกรรม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editTypeForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="edit_type_name" class="form-label">ชื่อกิจกรรม</label>
                                    <input type="text" class="form-control" id="edit_type_name" name="type_name" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        // เปิด Modal พร้อมดึงข้อมูล
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                // อัปเดตฟิลด์ใน Modal
                document.getElementById('edit_type_name').value = name;

                // อัปเดต action ของฟอร์ม
                document.getElementById('editTypeForm').action = `/typeactivity_update/${id}`;
            });
        });
    </script>

    <script>
        document.getElementById('addTypeForm').addEventListener('submit', function (e) {
            e.preventDefault(); // ป้องกันการรีเฟรชหน้า
            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ปิด Modal หลังจากบันทึกเสร็จ
                        $('#addTypeModal').modal('hide');

                        // แสดงข้อความสำเร็จด้วย SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                            timerProgressBar: true,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload(); // รีเฟรชหน้าเมื่อกด OK
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดบางอย่าง', 'error');
                });
        });
    </script>



    <script>
        // Event listener สำหรับปุ่มลบ
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener สำหรับปุ่มลบ
            document.querySelectorAll('.deleteBtn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault(); // ป้องกันการลบโดยตรง

                    const form = this.closest('form');
                    const deleteUrl = form.action;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // หากยืนยันการลบ
                        }
                    });
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                    timerProgressBar: true,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <script>
        document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.nav-tabs .nav-link').forEach(el => {
                    el.classList.remove('active', 'bg-warning', 'text-light');
                    el.classList.add('text-dark');
                });
                this.classList.add('active', 'bg-warning', 'text-light');
            });
        });
    </script>

    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




@endsection