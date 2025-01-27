@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <div class="row mb-3">
                <div class="col-auto">
                    <a href="{{ route('customer_create') }}" class="btn btn-primary">เพิ่มข้อมูลลูกค้า</a>
                </div>
                <div class="col-auto">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Top_up">เติมเงิน</button>
                </div>
                <div class="col-auto">
                    <a href="#top_up" class="btn btn-secondary">ข้อมูลการเติมเงิน </a>
                </div>
            </div>



            <div class="d-flex">
                <div class="mb-3">
                    <!-- ช่องกรอกวันที่ -->
                    <span><i class="fa-solid fa-calendar-days"></i></span>
                    <input type="date" id="createdDate" class="form-control" placeholder="ค้นหาตามวันที่">
                </div>
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาชื่อลูกค้า">
                </div>
                <div class="mb-3">
                    <!-- ช่องเลือกประเภทบริการ -->
                    <select class="form-select bg-warning" id="type_service" name="type_service">
                        <option value="" disabled selected>-- เลือกประเภทบริการ --</option>
                        <option value="">ทั้งหมด</option>
                        <option value="fttx_broadband">Fttxbroadband</option>
                        <option value="SIM my(เติมเงิน)">SIM my(เติมเงิน)</option>
                        <option value="SIM my(รายเดือน)">SIM my(รายเดือน)</option>
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


        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light text-center">
                    <th>#</th>
                    <th>ชื่อ-นามสกุล</th>
                    {{-- <th>เลขบัตรประชาชน</th>
                    <th>รูปภาพ</th>
                    <th>ที่อยู่</th> --}}
                    <th>กิจกรรม</th>
                    <th>บริการ</th>
                    <th>โปรโมชั่น</th>
                    <th>ความเร็ว</th>
                    <th>ราคา</th>
                    <th>(จังหวัด/ศูนย์บริการ)</th>

                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody id="customerTable">
                @if ($data->count() > 0)
                    @foreach ($data as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td> <!-- ใช้ $loop->iteration สำหรับลำดับแถว -->
                            <td>{{ $customer->cus_fullname }}</td>
                            {{-- <td>{{ $customer->id_card }}</td>
                            <td>
                                @if ($customer->cus_photo)
                                <img src="{{ asset('storage/' . $customer->cus_photo) }}" alt="Photo" style="width: 50px; height: 50px;">
                            @else
                                No Photo
                            @endif                            
                            </td>
                            <td>{{ $customer->cus_address }}</td> --}}
                            <td>{{ $customer->type->type_name ?? 'N/A' }}</td>
                            <td>{{ $customer->service->service_name ?? 'N/A' }}</td>
                            <td>{{ $customer->promotion->promotion_name ?? 'N/A' }}</td>
                            <td>{{ $customer->speed->speed_name ?? 'N/A' }}</td> <!-- ดึงชื่อจากสัมพันธ์ speed -->
                            <td>{{ $customer->price->price_name ?? 'N/A' }}</td> <!-- ดึงชื่อจากสัมพันธ์ price -->
                            <td>
                                {{ $customer->province->province_name ?? 'N/A' }} /
                                {{ $customer->center->center_name ?? 'N/A' }}
                            </td>
                            <td colspan="2">
                                <div class="dropdown-menu-start">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('customer_edit', $customer->cus_id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form id="deleteForm{{ $customer->cus_id }}"
                                            action="{{ route('customer_delete', $customer->cus_id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $customer->cus_id }})">Delete</button>
                                        </form>
                                        <!-- ปุ่ม View -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#customerModal{{ $customer->cus_id }}">
                                            View
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12" class="text-center">ไม่มีข้อมูลลูกค้า</td>
                    </tr>
                @endif
            </tbody>
        </table>



        <!-- Modal -->
        @foreach ($data as $customer)
            <div class="modal fade" id="customerModal{{ $customer->cus_id }}" tabindex="-1"
                aria-labelledby="customerModalLabel{{ $customer->cus_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customerModalLabel{{ $customer->cus_id }}">รายละเอียดลูกค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <p><span class="fw-bold text-dark">ชื่อ-นามสกุล:</span> {{ $customer->cus_fullname }}</p>
                            <p><span class="fw-bold text-dark">รหัสบัตรประชาชน:</span> {{ $customer->id_card }}</p>
                            <p><span class="fw-bold text-dark">ที่อยู่:</span> {{ $customer->cus_address }}</p>
                            <p><span class="fw-bold text-dark">กิจกรรม:</span>
                                {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">บริการ:</span>
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }}<a
                                    class="btn btn-warning btn-sm text-dark" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-html="true"
                                    data-bs-original-title="
                                    <div class='text-start py-3' style='padding: 10px; background-color: #f9f9f9; border-radius: 5px;'>
                                        <strong>ข้อมูลบริการของลูกค้า</strong><br>
                                        <span>----------------------------</span>
                                        <strong class='text-warning'>บริการ:   </strong> {{ $customer->service->service_name }}<br>
                                        @php
                                            $fttxData = \App\Models\Fttxbroadband::where(
                                                'cus_id',
                                                $customer->cus_id,
                                            )->first();
                                            $simmyData = \App\Models\Simmy::where('cus_id', $customer->cus_id)->first();
                                        @endphp
                                        @if ($fttxData && $customer->service->service_name == 'fttx_broadband')
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : 'ปรับโปรโมชั่น' }}<br>
                                            <strong class='text-warning'>งานติดตั้ง:   </strong> {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
@elseif ($simmyData && str_contains(strtolower($customer->service->service_name), 'sim my'))
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $simmyData->cus_new == 1 ? 'ลูกค้าใหม่' : 'ลูกค้า(ย้ายค่าย)' }}<br>
@else
<strong class='text-warning'>ประเภทลูกค้า:   </strong> ไม่ระบุ<br>
                                            <strong class='text-warning'>ข้อมูลเพิ่มเติม:   </strong> ไม่ระบุ
@endif
                                    </div>
                                ">
                                    รายละเอียด
                                </a>



                            </p>
                            <p><span class="fw-bold text-dark">โปรโมชั่น:</span>
                                {{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ความเร็ว:</span>
                                {{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ราคา:</span>
                                {{ $customer->price->price_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">จังหวัด:</span>
                                {{ $customer->province->province_name }}
                            </p>
                            <p><span class="fw-bold text-dark">ศูนย์บริการ:</span>
                                {{ $customer->center->center_name }}
                            </p>
                            <p><span class="fw-bold text-dark">หมายเหตุ</span> {{ $customer->other ?? 'ไม่ระบุ' }}</p>
                            @if ($customer->cus_photo)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $customer->cus_photo) }}" alt="Customer Photo"
                                        style="width: 100%; max-width: 100px;" class="mt-3">
                                </div>
                            @else
                                <p><strong>รูปถ่าย:</strong> ไม่มีรูปถ่าย</p>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <h3 class="mt-5" id="top_up">ข้อมูลการเติมเงิน</h3>
        <table class="table table-bordered text-center ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ลำดับ</th>
                    <th>หมายเลขโทรศัพท์</th>
                    <th>ยอดเงิน</th>
                    <th>จังหวัด</th>
                    <th>ศูนย์บริการ</th>

                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($TopUp as $TopUp)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $TopUp->phone ?? 'ไม่ระบุ' }}</td>
                        <td>{{ $TopUp->amount }}</td>
                        <td>{{ $TopUp->province->province_name ?? 'ไม่ระบุ' }}</td>
                        <td>{{ $TopUp->center->center_name ?? 'ไม่ระบุ' }}</td>
                        <td>

                            <!-- ปุ่ม Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editTopUpModal" data-url="{{ route('topUp_update', $TopUp->topUp_id) }}"
                                data-id="{{ $TopUp->topUp_id }}" data-name="{{ $TopUp->phone }}"
                                data-amount="{{ $TopUp->amount }}" data-province="{{ $TopUp->province_id }}"
                                data-center="{{ $TopUp->center_id }}">
                                แก้ไข
                            </button>

                            <form id="deleteForm{{ $TopUp->topUp_id }}"
                                action="{{ route('topUp_delete', $TopUp->topUp_id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="confirmDeleteTop({{ $TopUp->topUp_id }})">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach

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
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    value="{{ $TopUp->phone }}">
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control"
                                    value="{{ $TopUp->amount }}" required>
                            </div>

                            <label for="province_id" class="form-label">จังหวัด</label>
                            <select class="form-select bg-warning text-dark" id="province_id2" name="province_id"
                                required>
                                <option value="" disabled selected>-- เลือกจังหวัด --</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province_id }}"
                                        {{ $TopUp->province_id == $province->province_id ? 'selected' : '' }}>
                                        {{ $province->province_name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Center -->
                            <label for="center_id" class="form-label">ศูนย์บริการ</label>
                            <select class="form-select bg-warning text-dark" id="center_id2" name="center_id" required>
                                <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->center_id }}"
                                        {{ $TopUp->center_id == $center->center_id ? 'selected' : '' }}>
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
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
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
        function confirmDelete(customerId) {
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
                    document.getElementById('deleteForm' + customerId).submit();
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

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editTopUpForm');
                form.action = url;
                form.querySelector('#phone').value = name;
                form.querySelector('#amount').value = amount;
                form.querySelector('#province_id2').value = province;
                form.querySelector('#center_id2').value = center;
            });
        });
    </script>


    <script>
        //ค้นหา
        document.getElementById('searchInput').addEventListener('input', function() {
            let query = this.value;

            fetch("{{ route('customer_search') }}?search=" + query)
                .then(response => response.json())
                .then(data => {
                    let customerTable = document.getElementById('customerTable');
                    customerTable.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach((customer, index) => {
                            customerTable.innerHTML += `
                        
                            <tr>
                                <td>${index + 1}</td>
                                <td>${customer.cus_fullname}</td>
                                <td>${customer.type?.type_name || 'N/A'}</td>
                                <td>${customer.service?.service_name || 'N/A'}</td>
                                <td>${customer.promotion?.promotion_name || 'N/A'}</td>
                                <td>${customer.speed?.speed_name || 'N/A'}</td>
                                <td>${customer.price?.price_name || 'N/A'}</td>
                                <td>${customer.province?.province_name || 'N/A'} / ${customer.center?.center_name || 'N/A'}</td>
                                <td>
                                    <a href="/customer/edit/${customer.cus_id}" class="btn btn-warning btn-sm">Edit</a>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                     <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#customerModal{{ $customer->cus_id }}">
                                    View
                                </button>
                                
                                </td>
                            </tr>
                        `;
                        });
                    } else {
                        customerTable.innerHTML = `
                        <tr>
                            <td colspan="9" class="text-center">ไม่มีข้อมูลลูกค้า</td>
                        </tr>
                    `;
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

<script>
    //ค้นหา
    document.getElementById('createdDate').addEventListener('input', searchCustomers);
    document.getElementById('searchInput').addEventListener('input', searchCustomers);
    document.getElementById('type_service').addEventListener('change', searchCustomers);

    function searchCustomers() {
        let date = document.getElementById('createdDate').value;
        let searchName = document.getElementById('searchInput').value;
        let typeService = document.getElementById('type_service').value;

        // ส่งค่าผ่าน URL Params ไปยัง Backend
        let url = `/customers/search?date=${date}&name=${searchName}&service=${typeService}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let customerTable = document.getElementById('customerTable');
                customerTable.innerHTML = ''; // ลบข้อมูลเดิมในตาราง

                if (data.length > 0) {
                    data.forEach((customer, index) => {
                        customerTable.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${customer.cus_fullname}</td>
                        <td>${customer.type?.type_name || 'N/A'}</td>
                        <td>${customer.service?.service_name || 'N/A'}</td>
                        <td>${customer.promotion?.promotion_name || 'N/A'}</td>
                        <td>${customer.speed?.speed_name || 'N/A'}</td>
                        <td>${customer.price?.price_name || 'N/A'}</td>
                        <td>${customer.province?.province_name || 'N/A'} / ${customer.center?.center_name || 'N/A'}</td>
                        <td>
                             <div class="dropdown-menu-start">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <!-- ใช้ JavaScript ในการใส่ค่า ID ที่ถูกต้อง -->
                                    <a href="/customer_edit/${customer.cus_id}" class="btn btn-warning btn-sm">Edit</a>
                                    <form id="deleteForm${customer.cus_id}" action="/customer_delete/${customer.cus_id}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${customer.cus_id})">Delete</button>
                                    </form>
                                    <!-- ปุ่ม View -->
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#customerModal${customer.cus_id}">
                                        View
                                    </button>
                                </div>
                            </div>
                        
                        </td>
                    </tr>
                `;
                    });
                } else {
                    customerTable.innerHTML = `
                <tr>
                    <td colspan="11" class="text-center">ไม่มีข้อมูลลูกค้า</td>
                </tr>
            `;
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
@endsection
