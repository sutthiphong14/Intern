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
                            <tr class='bg-dark'>
                                <th>ตรวจสอบ</th>
                                <th>ผู้ร้องขอ</th>
                                <th>ชื่อ-สกุล</th>
                                <th>อีเมล</th>
                                <th>รายละเอียด</th>
                                <th>วันที่ส่งคำขอ</th>
                                <th>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <button class="btn btn-warning view-user-btn">
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
                                        <form action="{{ route('requests.approve', $request->id_request) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะยอมรับคำขอนี้?')">ยอมรับ</button>
                                        </form>

                                        <!-- ปุ่ม แก้ไข -->
                                        <a href="{{ route('requests.edit', $request->id_request) }}"
                                            class="btn btn-warning btn-sm">แก้ไข</a>

                                        <!-- ปุ่ม ลบ -->
                                        <form action="{{ route('requests.delete', $request->id_request) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำขอนี้?')">ลบ</button>
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
        </div>
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
                        <h5><strong>รายละเอียด:</strong> <span id="modal-description-request"></span></h5>
                        <h5><strong>วันที่ส่งคำขอ:</strong> <span id="modal-created-at"></span></h5>
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
        $(document).ready(function () {
            $('.view-user-btn').on('click', function () {
                // ค้นหาข้อมูลจากแถวที่กดปุ่ม
                var row = $(this).closest('tr');
                var userRequest = row.find('td:eq(1)').text().trim();
                var nameRequest = row.find('td:eq(2)').text().trim();
                var emailRequest = row.find('td:eq(3)').text().trim();
                var descriptionRequest = row.find('td:eq(4)').text().trim();
                var createdAt = row.find('td:eq(5)').text().trim();

                // ตรวจสอบว่ามีฟิลด์ข้อมูลเพิ่มเติมหรือไม่ (เผื่อไว้ใช้ในอนาคต)
                var departmentRequest = row.find('td:eq(6)').text().trim() || 'N/A';
                var provinceIdRequest = row.find('td:eq(7)').text().trim() || 'N/A';
                var centerIdRequest = row.find('td:eq(8)').text().trim() || 'N/A';

                // ใส่ข้อมูลลงใน Modal
                $('#modal-user-request').text(userRequest);
                $('#modal-name-request').text(nameRequest);
                $('#modal-email-request').text(emailRequest);
                $('#modal-description-request').text(descriptionRequest);
                $('#modal-created-at').text(createdAt);
                $('#modal-department-request').text(departmentRequest);
                $('#modal-province-id-request').text(provinceIdRequest);
                $('#modal-center-id-request').text(centerIdRequest);

                // แสดง Modal
                $('#userModal').modal('show');
            });
        });

    </script>
@endsection