<!-- listRequests.blade.php -->
@extends('admins.index')
@section('title')
    รายการคำขอ
@endsection
@section('header')
    รายการคำขอ
@endsection

@section('css')
    <style>
        .request-profile-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .modal-body h5 span {
            max-width: 100%;
            display: inline-block;
            word-wrap: break-word;
            overflow-wrap: break-word;
            height: auto;
        }


        #userModal .modal-dialog {
            max-width: 400px;
            /* ปรับความกว้างของ modal */
            height: auto;
            /* ความสูงปรับตามเนื้อหา */
        }

        #userModal .modal-content {
            height: auto;
            /* ความสูงของ content ปรับตามเนื้อหาภายใน */
        }
    </style>
@endsection

@section('content')
    <section class="content">
    <h4 class="fw-bold py-2 mb-3">
        <a href="{{ route('home') }}">หน้าแรก</a> / เพิ่มผู้ใช้งาน
    </h4>

        <div class="content-wrapper">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <h3 class="card-header text-dark">รายการคำขอ</h3>
                    
                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('requests.search') }}" method="GET" class="d-flex w-100">
                            <input type="text" name="query" class="form-control" placeholder="ค้นหาคำขอ..."
                                value="{{ request('query') }}">
                            <button type="submit" class="btn btn-info btn-dark">ค้นหา</button>
                        </form>
                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="example2" class="table table-hover text-center">
                        <thead class='text-center'>
                            <tr class='bg-dark col-12'>
                                <th class = 'col-1'>ตรวจสอบ</th>
                                <th class = 'col-1'>ผู้ร้องขอ</th>
                                <th class = 'col-2'>ชื่อ-สกุล</th>
                                <th class = 'col-2'>อีเมล</th>
                                <th class = 'col-3'>รายละเอียด</th>
                                <th class = 'col-1'>วันที่ส่งคำขอ</th>
                                <th class = 'col-2'>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <button class="btn btn-warning view-user-btn" data-bs-toggle="modal"
                                            data-bs-target="#userModal" data-user_request="{{ $request->user_request }}"
                                            data-name_request="{{ $request->name_request }}"
                                            data-password_request="{{ $request->password_request }}"
                                            data-email_request="{{ $request->email_request }}"
                                            data-description_request="{{ $request->description_request }}"
                                            data-created_at="{{ $request->created_at }}"
                                            data-department_request="{{ $request->department_request ?? 'N/A' }}"
                                            data-province="{{ $request->province->province_name ?? 'N/A' }}"
                                            data-center="{{ $request->serviceCenter->center_name ?? 'N/A' }}">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </td>

                                    <td>{{ $request->user_request }}</td>
                                    <td>{{ $request->name_request }}</td>
                                    <td>{{ $request->email_request }}</td>
                                    <td>{{ $request->description_request }}</td>
                                    <td>{{ $request->created_at }}</td>
                                    <td class="text-center">
                                        <!-- ปุ่ม ยอมรับ -->
                                        <a href="{{ route('requests.approve', $request->id_request) }}"
                                            class="btn btn-success btn-sm">
                                            ยอมรับ
                                        </a>

                                        <!-- ปุ่ม ลบ -->
                                        <form action="{{ route('requests.delete', $request->id_request) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำขอนี้?')">ปฎิเสธ</button>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="userModalLabel">รายละเอียดคำขอผู้ใช้</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5><strong>ผู้ร้องขอ:</strong> <span id="modal-user-request"></span></h5>
                        <h5><strong>ชื่อ-สกุล:</strong> <span id="modal-name-request"></span></h5>
                        <h5><strong>อีเมล:</strong> <span id="modal-email-request"></span></h5>
                        <h5><strong>รหัสผ่าน:</strong> <span id="modal-password-request"></span></h5>
                        <h5><strong>รายละเอียด:</strong> <span id="modal-description-request"></span></h5>
                        <h5><strong>วันที่ส่งคำขอ:</strong> <span id="modal-created-at"></span></h5>
                        <h5><strong>แผนก:</strong> <span id="modal-department-request"></span></h5>
                        <h5><strong>จังหวัด:</strong> <span id="modal-province-request"></span></h5>
                        <h5><strong>ศูนย์บริการ:</strong> <span id="modal-center-request"></span></h5>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const viewButtons = document.querySelectorAll(".view-user-btn");

            viewButtons.forEach(button => {
                button.addEventListener("click", function () {
                    // ดึงค่าจาก data-attributes
                    const userRequest = this.getAttribute("data-user_request");
                    const nameRequest = this.getAttribute("data-name_request");
                    const passwordRequest = this.getAttribute("data-password_request"); // เพิ่มการดึง password
                    const emailRequest = this.getAttribute("data-email_request");
                    const descriptionRequest = this.getAttribute("data-description_request");
                    const createdAt = this.getAttribute("data-created_at");
                    const departmentRequest = this.getAttribute("data-department_request");
                    const province = this.getAttribute("data-province");
                    const center = this.getAttribute("data-center");

                    // อัปเดตข้อมูลใน Modal
                    document.getElementById("modal-user-request").textContent = userRequest;
                    document.getElementById("modal-name-request").textContent = nameRequest;
                    document.getElementById("modal-password-request").textContent = passwordRequest; // แสดงรหัสผ่าน
                    document.getElementById("modal-email-request").textContent = emailRequest;
                    document.getElementById("modal-description-request").textContent = descriptionRequest;
                    document.getElementById("modal-created-at").textContent = createdAt;
                    document.getElementById("modal-department-request").textContent = departmentRequest;
                    document.getElementById("modal-province-request").textContent = province;
                    document.getElementById("modal-center-request").textContent = center;
                });
            });
        });

    </script>

@endsection