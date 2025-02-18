@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h3 class="text-center text-warning">-ลูกค้ากิจกรรม{{ $data->first()->type->type_name ?? '-' }}-😊</h3>
        <div class="d-flex justify-content-between">
            <div class="row mb-3">

                <div class="col-auto"> <a href="{{ route('customer_create') }}" class="btn btn-primary">เพิ่มข้อมูลลูกค้า</a>
                </div>

            </div>


            <div class="d-flex">
                <div class="mb-3">
                    <input type="hidden" id="type_id" value="{{ $data->first()->type->type_id }}">

                    <!-- ช่องกรอกวันที่ -->
                    <span><i class="fa-solid fa-calendar-days"></i></span>
                    <input type="date" id="createdDate" class="form-control" placeholder="ค้นหาตามวันที่">
                </div>
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาชื่อลูกค้า">
                </div>

                <div class="mb-2">
                    <!-- ช่องเลือกจังหวัด -->
                    <select class="form-select bg-warning" id="province_search" name="province_search">
                        <option value="" disabled selected>เลือกจังหวัด</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select>
                </div>


                <div style="margin-bottom: 40px;">
                    <span class="text-danger">* เลือกบริการ</span>

                    <!-- ช่องเลือกประเภทบริการ -->
                    <select class="form-select" id="type_service" name="type_service">

                        @foreach ($serviceTypes as $serviceType)
                            <option value="{{ $serviceType->service_name }}">{{ $serviceType->service_name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>







        <table class="table table-bordered">
            <thead id="table-heard">
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>โปรโมชั่น</th>
                    <th>ความเร็ว</th>
                    <th>ราคา</th>
                    <th>(จังหวัด/ศูนย์บริการ)</th>


                    <th>เครื่องมือ</th>
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

                            <td>{{ $customer->service->service_name ?? '-' }}</td>
                            <td>{{ $customer->promotion->promotion_name ?? '-' }}</td>
                            <td>{{ $customer->speed->speed_name ?? '-' }}</td> <!-- ดึงชื่อจากสัมพันธ์ speed -->
                            <td>{{ $customer->price->price_name ?? '-' }}</td> <!-- ดึงชื่อจากสัมพันธ์ price -->

                            <td>
                                {{ $customer->province->province_name ?? '-' }} /
                                {{ $customer->center->center_name ?? '-' }}
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



        <!-- Modal view -->
        @foreach ($data as $customer)
            <div class="modal fade" id="customerModal{{ $customer->cus_id }}" tabindex="-1"
                aria-labelledby="customerModalLabel{{ $customer->cus_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customerModalLabel{{ $customer->cus_id }}">รายละเอียดลูกค้า</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <p><span class="fw-bold text-dark">ชื่อ-นามสกุล:</span> {{ $customer->cus_fullname }}</p>
                            @if (strpos(strtolower($customer->service->service_name), 'fttx_broadband') !== false ||
                                    strpos(strtolower($customer->service->service_name), 'sim my') !== false)
                                <p><span class="fw-bold text-dark">รหัสบัตรประชาชน:</span> {{ $customer->id_card }}</p>
                            @else
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span>
                                    {{ $dataIct->first()->customer_type }}</p>
                            @endif
                            <p><span class="fw-bold text-dark">ที่อยู่:</span> {{ $customer->cus_address }}</p>
                            <p><span class="fw-bold text-dark">กิจกรรม:</span>
                                {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">บริการ:</span>
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }}
                                <a class="btn btn-warning btn-sm text-dark" data-bs-toggle="tooltip"
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
                                            $ictData = \App\Models\IctSolution::where(
                                                'cus_id',
                                                $customer->cus_id,
                                            )->first();

                                        @endphp
                                @if ($fttxData && str_contains(strtolower($customer->service->service_name), 'fttx_broadband'))
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : 'ปรับโปรโมชั่น' }}<br>
                                            <strong class='text-warning'>งานติดตั้ง:   </strong> {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
@elseif ($simmyData && str_contains(strtolower($customer->service->service_name), 'sim my'))
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $simmyData->cus_new == 1 ? 'ลูกค้าใหม่' : 'ลูกค้า(ย้ายค่าย)' }}<br>
@elseif ($ictData && str_contains(strtolower($customer->service->service_name), 'ict solution'))
<strong class='text-warning'>รายได้:   </strong> {{ $ictData->income }}
                                                    
                                                  
<br>
@else
<strong class='text-warning'>ประเภทลูกค้า:   </strong> ไม่ระบุ<br>
                                                            <strong class='text-warning'>ข้อมูลเพิ่มเติม:   </strong> ไม่ระบุ
@endif
                                            </div>
                                            ">
                                    รายละเอียด
                                </a>
                            </p>
                            @if (strpos(strtolower($customer->service->service_name), 'fttx_broadband') !== false ||
                                    strpos(strtolower($customer->service->service_name), 'sim my') !== false)
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
                            @endif

                            @if (strpos(strtolower($customer->service->service_name), 'ict') !== false)
                                <p><span class="fw-bold text-dark">จังหวัด:</span>
                                    {{ $customer->province->province_name }}
                                </p>
                                <p><span class="fw-bold text-dark">ศูนย์บริการ:</span>
                                    {{ $customer->center->center_name }}
                                </p>

                                @if ($dataIct->isNotEmpty() && $dataIct->first()->quote)
                                @php
                                    $quotePath = asset('storage/' . $dataIct->first()->quote);
                                    $fileExtension = pathinfo($dataIct->first()->quote, PATHINFO_EXTENSION);
                                @endphp
                            
                                <div class="d-flex">
                                    <p><span class="fw-bold text-dark">ใบเสนอราคา:</span></p>
                            
                                    @if (in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']))
                                        <!-- แสดงรูปภาพ -->
                                        <img src="{{ $quotePath }}" alt="Customer Quote"
                                            style="width: 100%; max-width: 100px;" class="mt-3">
                                    @elseif (strtolower($fileExtension) === 'pdf')
                                        <!-- แสดงลิงก์สำหรับไฟล์ PDF -->
                                        <p >
                                            <a href="{{ $quotePath }}" target="_blank" >
                                               <span class="btn-sm btn-info">คลิกเพื่อดู</span>
                                            </a>
                                        </p>
                                         
                                    @endif
                            
                                    <!-- ปุ่มดาวน์โหลด -->
                             
                                    <a href="{{ $quotePath }}" class="btn btn-success mb-3 btn-sm " download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            @else
                                <p><strong>ใบเสนอราคา:</strong> ไม่มีใบเสนอราคา</p>
                            @endif
                            <p><span class="fw-bold text-dark">หมายเหตุ</span> {{ $customer->other ?? 'ไม่ระบุ' }}</p>

                            

                            <p><span class="fw-bold text-dark">ข้อมูลสินค้า</span></p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center  bg-dark">
                                            <th>ชื่อสินค้า</th>
                                            <th>จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ictData->first()->products as $product)
                                            <tr class="text-center">
                                                <td>{{ $product->product_name?? 'ไม่มีสินค้า' }}</td>
                                                <td>{{ $product->pivot->quantity?? '-' }}</td> <!-- ดึงข้อมูลจาก pivot table -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach






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




    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        $(document).ready(function() {
            $('#province_search').select2({
                placeholder: "เลือกจังหวัด",
                allowClear: true
            });

            // ใช้ jQuery ดักจับค่า Select2 ที่เปลี่ยนแปลง
            $('#province_search').on('change', function() {
                searchCustomers();
            });
        });
    </script>

    <script>
        document.getElementById('createdDate').addEventListener('input', searchCustomers);
        document.getElementById('searchInput').addEventListener('input', searchCustomers);
        document.getElementById('type_service').addEventListener('change', searchCustomers);
        document.getElementById('province_search').addEventListener('change', searchCustomers);

        function searchCustomers() {
            let date = document.getElementById('createdDate').value;
            let searchName = document.getElementById('searchInput').value;
            let typeService = document.getElementById('type_service').value;
            let provinceId = document.getElementById('province_search').value;
            let typeId = document.getElementById('type_id').value; // เก็บค่า type_id

            // ส่งค่าผ่าน URL Params ไปยัง Backend
            let url =
                `/customers/search?date=${date}&name=${searchName}&service=${typeService}&type_id=${typeId}&province_id=${provinceId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let customerTable = document.getElementById('customerTable');
                    customerTable.innerHTML = ' '; // ลบข้อมูลเดิมในตาราง


                    // ตรวจสอบว่า typeService เป็น 'fttx' หรือ 'simmy' หรือ 'ict'
                    if (data.length > 0) {
                        // ตรวจสอบ typeService ที่ไม่สนใจตัวพิมพ์ใหญ่/เล็ก และช่องว่าง
                        if ((typeService.trim().toLowerCase().includes('fttx') || typeService.trim().toLowerCase()
                                .includes('sim my'))) {
                            data.forEach((customer, index) => {
                                let customerTableH = document.getElementById('table-heard');
                                customerTableH.innerHTML = `
      
            <tr class="bg-dark text-light">
                <th>#</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เลขบัตรประชาชน</th>
                <th>โปรโมชั่น</th>
                <th>ความเร็ว</th>
                <th>ราคา</th>
                <th>(จังหวัด/ศูนย์บริการ)</th>
                <th>เครื่องมือ</th>
            </tr>
     
    `;
                                customerTable.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${customer.cus_fullname}</td>
                                    <td>${customer.id_card}</td>
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
                                                <a href="/customer_edit/${customer.cus_id}" class="btn btn-warning btn-sm">Edit</a>
                                                <form id="deleteForm${customer.cus_id}" action="/customer_delete/${customer.cus_id}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${customer.cus_id})">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#customerModal${customer.cus_id}">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            });
                        }
                        // กรณีที่ typeService เป็น 'ict'
                        else if (typeService.trim().toLowerCase().includes('ict')) {
                            let customerTable = document.getElementById('customerTable');
                            let customerTableH = document.getElementById('table-heard');
                            customerTable.innerHTML = ''; // ลบข้อมูลเดิมในตาราง
                            customerTableH.innerHTML = '';
                            let dataIct = @json($dataIct); // ข้อมูล IctSolution
                            // จับคู่ข้อมูลจาก data และ dataIct



                            data.forEach((customer, index) => {
                                let customerTableH = document.getElementById('table-heard');
                                let ictData = dataIct.find(ict => ict.cus_id === customer.cus_id);

                                console.log(ictData)
                                customerTableH.innerHTML = `
                             <tr class="bg-dark text-light">
                              <th>#</th>
                                 <th>ชื่อ-นามสกุล</th>
                                <th>ประเภทลูกค้า</th>
                                <th>รายได้</th>
                                 <th>(จังหวัด/ศูนย์บริการ)</th>
                                 <th>เครื่องมือ</th>
                                 </tr>
                                    `;
                                // ค้นหาข้อมูล ICT ที่ตรงกับ customer



                                customerTable.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${customer.cus_fullname}</td>
                                      <td>${ictData ? ictData.customer_type : 'N/A'}</td> <!-- แสดงประเภทจาก ict -->
                <td>${ictData ? ictData.income : 'N/A'}</td> <!-- แสดงรายได้จาก ict -->
                                    <td>${customer.province?.province_name || 'N/A'} / ${customer.center?.center_name || 'N/A'}</td>
                                    <td>
                                        <div class="dropdown-menu-start">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="/customer_edit/${customer.cus_id}" class="btn btn-warning btn-sm">Edit</a>
                                                <form id="deleteForm${customer.cus_id}" action="/customer_delete/${customer.cus_id}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${customer.cus_id})">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#customerModal${customer.cus_id}">
                                                    View
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            });

                            // เพิ่มการแสดงผลสำหรับประเภท ICT
                            // คุณสามารถจัดการเฉพาะข้อมูลที่เป็นประเภท ICT ตามที่ต้องการ
                        } else {
                            customerTable.innerHTML = `
                            <tr>
                                <td colspan="11" class="text-center">ไม่มีข้อมูลลูกค้า</td>
                            </tr>
                        `;
                        }
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

        // เรียกใช้ฟังก์ชันการค้นหาทันทีเมื่อหน้าโหลด
        document.addEventListener('DOMContentLoaded', function() {
            searchCustomers(); // เรียกใช้ฟังก์ชันนี้หลังจากหน้าโหลดเสร็จ
        });
    </script>
@endsection
