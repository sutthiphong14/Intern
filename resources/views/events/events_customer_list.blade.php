@extends('admins.index')
@section('css')
<style>
    /* ขยายขนาด tooltip */
    .tooltip-inner {
        max-width: 300px; /* กำหนดขนาดสูงสุดของ tooltip */
        font-size: 1.2rem; /* ปรับขนาดตัวอักษร */
        padding: 15px; /* ปรับ padding ของ tooltip */
   
        border-radius: 5px; /* มุมโค้งมน */
    }

    /* กำหนดความสูงของ modal ให้เล็กลง */
    .modal-dialog {
    max-width: 500px; /* กำหนดความกว้างตามต้องการ */
    height: auto;
}

.modal-content {
    height: auto;
}


 
</style>
@endsection


@section('content')
    <h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
            <a href="{{ route('home') }}" class="">
                หน้าแรก
            </a>
            /
            <a href="{{ route('type_list') }}" class="">
                ข้อมูลกิจกรรม
            </a>
            /
        </span> ข้อมูลลูกค้า
    </h4>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h3 class="card-header text-dark">ข้อมูลลูกค้ากิจกรรม {{ $types->first()->type_name ?? '-' }}</h3>
            <div class="d-flex align-items-center gap-2">

                <div class="d-flex align-items-center gap-2">
                <form id="searchForm">

        <!-- ค้นหาตามชื่อ -->

            <input type="text" id="searchInput" name="name" class="form-control" placeholder="ค้นหาชื่อลูกค้า" width = '100px'>

</form>
                    


                    @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) || (Auth::user()->permission['form_event'] ?? false ))
                    <div class="col-auto"> <a href="{{ route('customer_create', $type_id) }}"
                            class="btn btn-success">เพิ่มข้อมูลลูกค้า</a>
                    </div>
                    <a href="{{ route('top_up_list', $type_id) }}" class="btn btn-warning col-auto">เติมเงินรายปี</a>
                    @endif

                    <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                        data-bs-target="#modalScrollable">
                        <i class="fas fa-question-circle"></i>
                    </button>
                </div>
            </div>
        </div>


        <div class="mb-3">

        <div class="card-body">
        <div class="table-responsive ">
            <table class="table table-bordered text-center">
                <thead id="table-heard">
                    <tr class="bg-dark text-light">
                    
                    <th>ตรวจสอบ</th>

                        <th>ชื่อ-นามสกุล</th>
                        <th>บริการ</th>

                        <th>(จังหวัด/ศูนย์บริการ)</th>

                        @if((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false)  )
                        <th>เครื่องมือ</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="customerTable">
                    @if ($data->count() > 0)
                        @foreach ($data as $customer)
                            <tr>
                                <td><button type="button" class="btn bg-warning" data-bs-toggle="modal"
                                                    data-bs-target="#customerModal{{ $customer->cus_id }}">
                                                    <i class="fas fa-search"></i>
                                                </button></td>
                                <td>{{ $customer->cus_fullname }}</td>
                                {{-- <td>{{ $customer->id_card }}</td>
                                <td>
                                    @if ($customer->cus_photo)
                                    <img src="{{ asset('storage/' . $customer->cus_photo) }}" alt="Photo"
                                        style="width: 50px; height: 50px;">
                                    @else
                                    No Photo
                                    @endif
                                </td>
                                <td>{{ $customer->cus_address }}</td> --}}

                                <td>{{ $customer->service->service_name ?? '-' }}</td>


                                <td>
                                    {{ $customer->province->province_name ?? '-' }} /
                                    {{ $customer->center->center_name ?? '-' }}
                                </td>
                                @if ((Auth::user()->permission['adminper_mission'] ?? false) || (Auth::user()->permission['manage_formevent'] ?? false) )
                                <td colspan="2">
                                    <div class="dropdown-menu-start">
                                        <button type="button" class="btn btn-light btn-sm p-1 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow border-0 rounded">
                                            <li>
                                                <a href="{{ route('customer_edit', $customer->cus_id) }}"
                                                    class="dropdown-item text-dark">
                                                    <i class="bx bx-edit"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form id="deleteForm{{ $customer->cus_id }}"
                                                    action="{{ route('customer_delete', $customer->cus_id) }}" method="POST"
                                                    class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="dropdown-item text-danger"
                                                        onclick="confirmDelete({{ $customer->cus_id }})">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </td>
                                @endif

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
                                    @if (
                                        strpos(strtolower($customer->service->service_name), 'fttx') !== false ||
                                        strpos(strtolower($customer->service->service_name), 'sim') !== false
                                    )
                                                            <p><span class="fw-bold text-dark">รหัสบัตรประชาชน:</span> {{ $customer->id_card ?? 'ไม่ระบุ' }}</p>
                                    @else
                                        <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span>
                                        {{ $dataIct->where('cus_id', $customer->cus_id)->first() ? $dataIct->where('cus_id', $customer->cus_id)->first()->customer_type : 'ไม่มีข้อมูล' }}
                                        </p>
                                    @endif
                                    <p><span class="fw-bold text-dark">ที่อยู่:</span> {{ $customer->cus_address ?? 'ไม่ระบุ' }}</p>
                                    <p><span class="fw-bold text-dark">กิจกรรม:</span>
                                        {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                                    </p>
                                    <p><span class="fw-bold text-dark">บริการ:</span>
                                        {{ $customer->service->service_name ?? 'ไม่ระบุ' }}
                                        <a class="btn btn-warning btn-sm text-dark" data-bs-toggle="tooltip"
                                            data-bs-placement="right" data-bs-html="true" data-bs-original-title="
                                                                                                                    <div class='text-start py-3' style=' background-color: #f9f9f9; border-radius: 5px;'>
                                                                                                                        <strong>ข้อมูลบริการของลูกค้า</strong><br>
                                                                                                                        <span>------------------------------</span>
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
                                                                                                                @if ($fttxData && str_contains(strtolower($customer->service->service_name), 'fttx'))
                                                                                                                   <strong class='text-warning d-inline'>ประเภทลูกค้า: </strong> 
                                                                                                                             <span class='text-sm d-inline'>   {{ 
                                                                                                                                    $fttxData->new == 1 ? 'ลูกค้าใหม่' : 
                                                                                                                                    ($fttxData->new == 2 ? 'ลูกค้าย้ายค่าย' : 'ปรับโปรโมชั่น') 
                                                                                                                                                                                        }}</span><br>

                                                                                                                                                                <strong class='text-warning'>งานติดตั้ง:   </strong> {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
                                                                                                                @elseif ($simmyData && str_contains(strtolower($customer->service->service_name), 'sim'))
                                                                                                                    <strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $simmyData->cus_new == 1 ? 'ลูกค้าใหม่' : 'ลูกค้า(ย้ายค่าย)' }}<br>
                                                                                                                @elseif ($ictData && str_contains(strtolower($customer->service->service_name), 'ict'))
                                                                                                                    <strong class='text-warning'>รายได้ต่อเดือน:   </strong> {{ $ictData->income }}


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
                                    @if (
                                        strpos(strtolower($customer->service->service_name), 'fttx') !== false ||
                                        strpos(strtolower($customer->service->service_name), 'sim') !== false
                                    )
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
                                                                <p><span class="fw-bold text-dark">รูปถ่าย:</span> ไม่มีรูปถ่าย</p>
                                                            @endif
                                    @endif

                                    @if (strpos(strtolower($customer->service->service_name), 'ict') !== false)
                                                    <p><span class="fw-bold text-dark">จังหวัด:</span>
                                                        {{ $customer->province->province_name }}
                                                    </p>
                                                    <p><span class="fw-bold text-dark">ศูนย์บริการ:</span>
                                                        {{ $customer->center->center_name }}
                                                    </p>
                                                    

                                                    @if ($dataIct->isNotEmpty() && $dataIct->where('cus_id', $customer->cus_id)->first()->quote)
                                                                    @php
                                                                        $quotePath = asset(
                                                                            'storage/' . $dataIct->where('cus_id', $customer->cus_id)->first()->quote,
                                                                        );
                                                                        $fileExtension = pathinfo(
                                                                            $dataIct->where('cus_id', $customer->cus_id)->first()->quote,
                                                                            PATHINFO_EXTENSION,
                                                                        );
                                                                    @endphp

                                                                    <div class="d-flex">
                                                                        <p><span class="fw-bold text-dark">ใบเสนอราคา:</span></p>

                                                                        @if (in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']))
                                                                            <!-- แสดงรูปภาพ -->
                                                                            <br>
                                                                            <img src="{{ $quotePath }}" alt="Customer Quote" style="width: 100%; max-width: 100px;"
                                                                                class="mt-3">
                                                                        @elseif (strtolower($fileExtension) === 'pdf')
                                                                            <!-- แสดงลิงก์สำหรับไฟล์ PDF -->
                                                                            <p>
                                                                                <a href="{{ $quotePath }}" target="_blank">
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
                                                        <p><span class="fw-bold text-dark">ใบเสนอราคา:</span> ไม่มีใบเสนอราคา</p>
                                                    @endif
                                                    <p><span class="fw-bold text-dark">หมายเหตุ</span> {{ $customer->other ?? 'ไม่ระบุ' }}</p>



                                                    
                                                    @php
                                                    // ดึงข้อมูล ict_solution ที่ตรงกับ cus_id
                                                    $ictSolution = $dataIct->where('cus_id', $customer->cus_id)->first();
                                                
                                                    // ดึง ict_service_name จาก ict_service_id
                                                    $serviceName = '';
                                                    if ($ictSolution) {
                                                        $service = \App\Models\IctService::find($ictSolution->ict_service_id); // หาบันทึกในตาราง IctService ที่มี ict_service_id
                                                        $serviceName = $service ? $service->service_name : 'ไม่พบข้อมูลบริการ'; // ถ้าหาเจอให้แสดง service_name
                                                    }
                                                @endphp
                                                <p><span class="fw-bold text-dark">หมวดหมู่บริการ ICT:</span> {{ $serviceName ?? 'ไม่ระบุ' }}</p>
                                                
                                                <p><span class="fw-bold text-dark">ข้อมูลสินค้า</span></p>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="text-center  bg-dark">
                                                                <th>ชื่อสินค้า</th>
                                                                <th>จำนวน</th>
                                                                <th>ราคา <br>ต่อหน่วย</th>
                                                                <th>รวม</th>
                                                            </tr>
                                                        </thead>
                                                        @php
                                                             $totalSum = 0;
                                                        @endphp
                                                        <tbody>
                                                            @if ($dataIct->where('cus_id', $customer->cus_id)->isNotEmpty())
                                                                @foreach ($dataIct->where('cus_id', $customer->cus_id)->first()->products as $product)
                                                                    <tr class="text-center">
                                                                        <td>{{ $product->product_name ?? 'ไม่มีสินค้า' }}</td>
                                                                        <td>{{ $product->pivot->quantity ?? '-' }}</td>
                                                                        <td>{{ $product->pivot->price ?? '-' }}</td>
                                                                        <td>
                                                                            @php
                                                                             
                                                                                $total = ($product->pivot->quantity ?? 0) * ($product->pivot->price ?? 0);
                                                                                $totalSum += $total;  // เพิ่มผลรวมที่คำนวณในแต่ละรอบ
                                                                            @endphp
                                                                            {{ $total }}
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                 

                                                                @endforeach
                                                                <tr>
                                                                    <td colspan="3"><strong>รายได้ต่อเดือน</strong></td>
                                                                    <td>{{ $totalSum }}</td>  <!-- แสดงผลรวมทั้งหมด -->
                                                                </tr>
                                                                
                                                            @else
                                                                <tr>
                                                                    <td colspan="2">ไม่มีข้อมูลสินค้า</td>
                                                                </tr>
                                                            @endif

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
        </div>
        </div>
    <div class="d-flex justify-content-center align-items-center me-4">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            {{-- ลิงก์หน้าแรกสุด --}}
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

            {{-- หมายเลขหน้า --}}
            @foreach (range(1, $data->lastPage()) as $page)
                <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $data->appends(request()->query())->url($page) }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- ลิงก์หน้าถัดไป --}}
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


@endsection

@section('script')
    <script>
        $('#province_id').change(function () {
            var provinceId = $(this).val();

            $.ajax({
                url: '/getCenters',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function (data) {
                    $('#center_id').empty();
                    $('#center_id').append(
                        '<option value="" disabled selected>-- เลือกศูนย์บริการ --</option>');
                    $.each(data, function (index, center) {
                        $('#center_id').append('<option class="bg-secondary" value="' + center
                            .center_id + '">' +
                            center.center_name + '</option>');
                    });
                },
                error: function () {
                    console.log('Error fetching centers');
                }
            });
        });
    </script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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

    <script>
        document.getElementById('searchInput').addEventListener('input', searchCustomers);
document.getElementById('type_service').addEventListener('change', searchCustomers);
document.getElementById('province_search').addEventListener('change', searchCustomers);

function searchCustomers() {
    let searchName = document.getElementById('searchInput').value;
    let typeService = document.getElementById('type_service').value;
    let provinceId = document.getElementById('province_search').value;

    let url = `/customers/search?name=${searchName}&service=${typeService}&province_id=${provinceId}`;

    console.log("🔎 กำลังค้นหา: ", url); // Debug URL

    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('customerTableContainer').innerHTML = html;
        })
        .catch(error => console.error("❌ Error:", error));
}
    </script>

    
@endsection