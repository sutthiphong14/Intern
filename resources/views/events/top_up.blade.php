@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <div class=" d-flex align-items-end justify-content-center ">
            <h3 class="text-warning" id="top_up" >-ข้อมูลการเติมเงิน-</h3>
        </div>
        <div class="text-warning d-flex align-items-end justify-content-center ">
            <h5>กิจกกรม {{ $types->first()->type_name ?? '-' }}</h5>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <!-- ปุ่มเติมเงิน (ซ้ายสุด) -->
            <div>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Top_up">เพิ่มข้อมูล</button>
            </div>

            <!-- ช่องค้นหาและเลือกประเภทบริการ (ขวาสุด) -->
            <div class="d-flex gap-3 mb-3">
                <div class="w-auto">
                    <span><i class="fa-solid fa-calendar-days"></i></span>
                    <input type="date" id="createdDate" name="date" class="form-control" placeholder="ค้นหาตามวันที่">
                </div>

                <div class="flex-grow-1">
                    <input type="text" id="searchInput" name="phone" class="form-control"
                        placeholder="ค้นหาหมายเลขโทรศััพท์">
                </div>

                <input type="hidden" name="type_idcheck" id="type_idcheck" value="{{ $types->first()->type_id }}">

                <div class="mt-2">
                    <!-- ช่องเลือกจังหวัด -->
                    <select class="form-select bg-warning" id="province_search" name="province_search">
                        <option value="" disabled selected>เลือกจังหวัด</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>


            </div>
        </div>

        <!-- Modal สำหรับเติมเงิน -->
        <div class="modal fade" id="Top_up" tabindex="-1" aria-labelledby="Top_uplLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="priceForm" action="{{ route('topUp_insert') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="PriceModalLabel">เติมเงิน</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="type_id" class="form-label">กิจกรรม</label>
                                <select class="form-select bg-warning text-dark" id="type_id" name="type_id" required>
                                    @foreach ($types as $type)
                                        <option class="bg-secondary" value="{{ $type->type_id }}">
                                            {{ $type->type_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">หมายเลขโทรศัพท์มือถือ</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">จำนวนเงินที่เติม</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>

                            <label for="province_id" class="form-label">จังหวัด</label>
                            <select class="form-select bg-warning text-dark" id="province_id" name="province_id" required>
                                <option value="" disabled selected>-- เลือกจังหวัด --</option>
                                @foreach ($provinces as $province)
                                    <option class="bg-secondary" value="{{ $province->province_id }}">
                                        {{ $province->province_name }}</option>
                                @endforeach
                            </select>


                            <!-- Center -->
                            <label for="center_id" class="form-label">ศูนย์บริการ</label>
                            <select class="form-select bg-warning text-dark" id="center_id" name="center_id" required>
                                <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                            </select>

                        </div>
                        <div class="modal-footer ">
                            <button type="submit" class="btn btn-success">บันทึก</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>




        <table class=" table table-bordered text-center ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ลำดับ</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>ยอดเงิน</th>
                    <th>จังหวัด/ศูนย์บริการ</th>


                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody id="topUpTable">
                @forelse ($TopUp as $topUp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $topUp->phone ?? 'ไม่ระบุ' }}</td>
                    <td>{{ $topUp->amount }}</td>
                    <td>{{ $topUp->province->province_name ?? 'ไม่ระบุ' }} /
                        {{ $topUp->center->center_name ?? 'ไม่ระบุ' }}</td>
                    <td colspan="2">
                        <div class="dropdown">
                            <button type="button" class="btn btn-light btn-sm p-1 dropdown-toggle hide-arrow"
                                data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded fs-5"></i>
                            </button>
                            <ul class="dropdown-menu shadow border-0 rounded">
                                <li>
                                    <button class="dropdown-item text-warning editBtn" data-bs-toggle="modal"
                                        data-bs-target="#editTopUpModal"
                                        data-url="{{ route('topUp_update', $topUp->topUp_id) }}"
                                        data-id="{{ $topUp->topUp_id }}" data-name="{{ $topUp->phone }}"
                                        data-amount="{{ $topUp->amount }}" data-province="{{ $topUp->province_id }}"
                                        data-center="{{ $topUp->center_id }}" data-type={{ $topUp->type_id }}>
                                        แก้ไข
                                    </button>
                                </li>
                                <li>
                                    <form id="deleteForm{{ $topUp->topUp_id }}"
                                        action="{{ route('topUp_delete', $topUp->topUp_id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger deleteBtn"
                                            onclick="confirmDeleteTop({{ $topUp->topUp_id }})">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
                </tr>
            @endforelse
            

            </tbody>
        </table>

        <!-- Modal สำหรับแก้ไข -->
        <div class="modal fade" id="editTopUpModal" tabindex="-1" aria-labelledby="editTopUpModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTopUpModalLabel">แก้ไขโปรโมชั่น</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editTopUpForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                    <label for="type_id" class="form-label">กิจกรรม</label>
                                    <select class="form-select bg-warning text-dark" id="type_id2" name="type_id2" required>
                                        @foreach ($types as $type)
                                            <option class="bg-secondary" value="{{ $type->type_id }}" 
                                                {{ $type->type_id ? 'selected' : '' }}>
                                                {{ $type->type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                  
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>

                            <label for="province_id" class="form-label">จังหวัด</label>
                            <select class="form-select bg-warning text-dark" id="province_id2" name="province_id"
                                required>
                                <option value="" disabled selected>-- เลือกจังหวัด --</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province_id }}"
                                        {{ $province->province_id ? 'selected' : '' }}>
                                        {{ $province->province_name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Center -->
                            <label for="center_id" class="form-label">ศูนย์บริการ</label>
                            <select class="form-select bg-warning text-dark" id="center_id2" name="center_id" required>
                                <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->center_id }}" {{ $center->center_id ? 'selected' : '' }}>
                                        {{ $center->center_name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#province_search').select2({
                placeholder: "เลือกจังหวัด",
                allowClear: true
            });

            // ใช้ jQuery ดักจับค่า Select2 ที่เปลี่ยนแปลง
            $('#province_search').on('change', function() {
                searchTopUp();
            });
        });
    </script>


    <script>
        $('#province_id').change(function() {
            var provinceId = $(this).val();

            $.ajax({
                url: '/getCenters',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function(data) {
                    $('#center_id').empty();
                    $('#center_id').append(
                        '<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                    $.each(data, function(index, center) {
                        $('#center_id').append('<option class="bg-secondary" value="' + center
                            .center_id + '">' +
                            center.center_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching centers');
                }
            });
        });
    </script>

    <script>
        $('#province_id2').change(function() {
            var provinceId = $(this).val();

            $.ajax({
                url: '/getCenters',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function(data) {
                    $('#center_id2').empty();
                    $('#center_id2').append(
                        '<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                    $.each(data, function(index, center) {
                        $('#center_id2').append('<option class="bg-secondary" value="' + center
                            .center_id + '">' +
                            center.center_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching centers');
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: '{{ session('success') }}',
                    timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                    timerProgressBar: true,
                    confirmButtonText: 'ตกลง'

                });
            });
        </script>
    @endif
    <script>
        function confirmDeleteTop(topUpId) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "การลบนี้ไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + topUpId).submit();
                }
            });
        }
    </script>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editTopUpModal = document.getElementById('editTopUpModal');
            editTopUpModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const amount = button.getAttribute('data-amount');
                const province = button.getAttribute('data-province');
                const center = button.getAttribute('data-center');
                const type = button.getAttribute('data-type');

                

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editTopUpForm');
                form.action = url;
                form.querySelector('#phone').value = name;
                form.querySelector('#amount').value = amount;
                form.querySelector('#province_id2').value = province;
                form.querySelector('#center_id2').value = center;
                form.querySelector('#type_id2').value = type;
            });
        });
    </script>

    <script>
        document.getElementById('createdDate').addEventListener('input', searchTopUp);
        document.getElementById('searchInput').addEventListener('input', searchTopUp);
        document.getElementById('type_idcheck').addEventListener('input', searchTopUp);
        document.getElementById('province_search').addEventListener('change', searchTopUp);
     
        
        function searchTopUp() {
            let date = document.getElementById('createdDate').value;
            let searchPhone = document.getElementById('searchInput').value;
            let provinceId = document.getElementById('province_search').value;
            let typeCheck = document.getElementById('type_idcheck').value;
            

            // ส่งค่าผ่าน URL Params ไปยัง Backend
            let url = `/topups/search?date=${date}&phone=${searchPhone}&province_id=${provinceId}&type_id=${typeCheck}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let topUpTable = document.getElementById('topUpTable');
                    topUpTable.innerHTML = ''; // ลบข้อมูลเดิมในตาราง

                    if (data.length > 0) {
                        data.forEach((TopUp, index) => {
                            topUpTable.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${TopUp.phone || 'ไม่ระบุ'}</td>
                            <td>${TopUp.amount}</td>
                            <td>${TopUp.province?.province_name || 'ไม่ระบุ'} /
                                ${TopUp.center?.center_name || 'ไม่ระบุ'}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-light btn-sm p-1 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 rounded">
                                        <li>
                                            <button class="dropdown-item text-warning editBtn" data-bs-toggle="modal"
                                                data-bs-target="#editTopUpModal"
                                                data-url="/topUp_update/${TopUp.topUp_id}"
                                                data-id="${TopUp.topUp_id}" data-name="${TopUp.phone}"
                                                data-amount="${TopUp.amount}" data-province="${TopUp.province_id}"
                                                data-center="${TopUp.center_id}" data-type=${TopUp.type_id}>
                                                แก้ไข
                                            </button>
                                        </li>
                                        <li>
                                            <form id="deleteForm${TopUp.topUp_id}"
                                                action="/topUp_delete/${TopUp.topUp_id}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger deleteBtn"
                                                    onclick="confirmDeleteTop(${TopUp.topUp_id})">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `;
                        });
                    } else {
                        topUpTable.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">ไม่มีข้อมูลการเติมเงิน</td>
                    </tr>
                `;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // เรียกใช้ฟังก์ชันการค้นหาทันทีเมื่อหน้าโหลด
        document.addEventListener('DOMContentLoaded', function() {
            searchTopUp(); // เรียกใช้ฟังก์ชันนี้หลังจากหน้าโหลดเสร็จ
        });
    </script>
@endsection
