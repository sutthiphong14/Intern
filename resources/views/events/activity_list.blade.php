@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <div class="row mb-3">
                <div class="col-auto">
                    {{-- <a href="{{ route('customer_create') }}" class="btn btn-primary">เพิ่มข้อมูลลูกค้า</a> --}}
                </div>
                <div class="col-auto">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Top_up">เติมเงิน</button>
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
                        @foreach ($serviceTypes as $serviceType)
                            <option value="{{ $serviceType->service_name }}">{{ $serviceType->service_name }}</option>
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
                                    <option value="" disabled selected>-- เลือกกิจกรรม --</option>
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


        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
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
                            <td>{{ $customer->type->type_name ?? '-' }}</td>
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
<strong class='text-warning'>รายได้:   </strong> {{ $ictData->income }}<br>
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




        <div class="mt-5">
            <h3>สรุปรายงานผลการดำเนินงานกิจกรรมการตลาด</h3>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ลำดับ</th>
                    <th rowspan="4">จังหวัด</th>
                    <th colspan="3">FTTX</th>
                    <th colspan="4">SIM my</th>
                    <th colspan="2">Ict Solution</th>



                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="4">new</th>
                    <th rowspan="4">ติดตั้งเอง</th>
                    <th rowspan="4">จ้างผู้รับเหมา</th>


                </tr>
                <tr class="bg-dark text-center">
                    <th rowspan="2">ลูกค้าใหม่</th>
                    <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
                    <th colspan="2">เติมเงินรายปี</th>
                    <th rowspan="2">จำนวน
                        (ราย)</th>
                    <th rowspan="2">รายได้</th>

                </tr>
                <tr class="bg-dark text-center ">
                    <th>จำนวน
                        (ราย)</th>
                    <th>ยอดเงิน</th>
                </tr>

            </thead>
            @php
                $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0; // สำหรับ province_id <= 33
                $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0; // สำหรับ province_id > 33

                $sumNew = $sumMove = $sumCount = $sumPrice = 0; // สำหรับ province_id <= 33
                $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0; // สำหรับ province_id > 33
                $IctCount = $IctIncome = 0; // สำหรับ province_id <= 33
                $IctCountOver33 = $IctIncomeOver33 = 0; // สำหรับ province_id > 33
            @endphp
            <tbody class="text-center">
                @foreach ($provinces as $index => $province)
                    {{-- Province ID <= 33 --}}
                    @if ($province->province_id <= 12)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                        </tr>

                        @php
                            $sumFttxNew += $fttxNew[$province->province_id] ?? 0;
                            $sumSelfInstall += $selfInstall[$province->province_id] ?? 0;
                            $sumHireInstall += $HireInstall[$province->province_id] ?? 0;
                            $sumNew += $Simmy_new[$province->province_id] ?? 0;
                            $sumMove += $Simmy_move[$province->province_id] ?? 0;
                            $sumCount += $Simmy_count[$province->province_id] ?? 0;
                            $sumPrice += $Simmy_price[$province->province_id] ?? 0;
                            $IctCount += $Ict_count[$province->province_id] ?? 0;
                            $IctIncome += $Ict_income[$province->province_id] ?? 0;
                        @endphp
                    @endif
                    {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                    @if ($province->province_id == 12)
                        <tr class="bg-warning">
                            <td colspan="2">รวม ตป.1</td>
                            <td>{{ $sumFttxNew }}</td>
                            <td>{{ $sumSelfInstall }}</td>
                            <td>{{ $sumHireInstall }}</td>

                            <td>{{ $sumNew }}</td>
                            <td>{{ $sumMove }}</td>
                            <td>{{ $sumCount }}</td>
                            <td>{{ $sumPrice }}</td>
                            <td>{{ $IctCount }}</td>
                            <td>{{ $IctIncome }}</td>
                        </tr>
                    @endif
                    {{-- Province ID > 33 --}}
                    @if ($province->province_id > 12)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                        </tr>
                        @php
                            $sumFttxNewOver33 += $fttxNew[$province->province_id] ?? 0;
                            $sumSelfInstallOver33 += $selfInstall[$province->province_id] ?? 0;
                            $sumHireInstallOver33 += $HireInstall[$province->province_id] ?? 0;

                            $sumNewOver33 += $Simmy_new[$province->province_id] ?? 0;
                            $sumMoveOver33 += $Simmy_move[$province->province_id] ?? 0;
                            $sumCountOver33 += $Simmy_count[$province->province_id] ?? 0;
                            $sumPriceOver33 += $Simmy_price[$province->province_id] ?? 0;
                            $IctCountOver33 += $Ict_count[$province->province_id] ?? 0;
                            $IctIncomeOver33 += $Ict_income[$province->province_id] ?? 0;
                        @endphp
                    @endif
                @endforeach

                {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.2</td>
                    <td>{{ $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstallOver33 }}</td>

                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                    <td>{{ $IctCountOver33 }}</td>
                    <td>{{ $IctIncomeOver33 }}</td>
                </tr>

                <tr class="bg-success">
                    <td colspan="2">รวม ทั้งหมด</td>
                    <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>

                    <td>{{ $sumNew + $sumNewOver33 }}</td>
                    <td>{{ $sumMove + $sumMoveOver33 }}</td>
                    <td>{{ $sumCount + $sumCountOver33 }}</td>
                    <td>{{ $sumPrice + $sumPriceOver33 }}</td>
                    <td>{{ $IctCount + $IctCountOver33 }}</td>
                    <td>{{ $IctIncome + $IctIncomeOver33 }}</td>
                </tr>
            </tbody>



        </table>




<!-- Fttx Graph -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" id="fttxGraphHeading">
        <h5 class="mb-0 text-dark">
            กราฟ Fttx broadband
        </h5>
        <button class="toggle-btn btn btn-link ms-auto" data-bs-toggle="collapse" data-bs-target="#fttxGraph"
            aria-expanded="true" aria-controls="fttxGraph">
            <i class="fas fa-chevron-down text-dark fa-rotate-180"></i>
        </button>
    </div>
    <div id="fttxGraph" class="collapse show" aria-labelledby="fttxGraphHeading">
        <div class="card-body">
            <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width:100%;"></canvas>
        </div>
    </div>
</div>
<hr>

<!-- SIM my Graph -->
<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center" id="simMyGraphHeading">
        <h5 class="mb-0 text-dark">
            กราฟ SIM my
        </h5>
        <button class="toggle-btn btn btn-link ms-auto" data-bs-toggle="collapse" data-bs-target="#simMyGraph"
            aria-expanded="true" aria-controls="simMyGraph">
            <i class="fas fa-chevron-down text-dark fa-rotate-180"></i>
        </button>
    </div>
    <div id="simMyGraph" class="collapse show" aria-labelledby="simMyGraphHeading">
        <div class="card-body">
            <canvas id="simMyChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width:100%;"></canvas>
        </div>
    </div>
</div>
<hr>

<!-- ICT Solution Graph -->
<div class="card mt-3">
    <div class="card-header d-flex justify-content-between align-items-center" id="ICTGraphHeading">
        <h5 class="mb-0 text-dark">
            กราฟ ICT Solution
        </h5>
        <button class="toggle-btn btn btn-link ms-auto" data-bs-toggle="collapse" data-bs-target="#ICTGraph"
            aria-expanded="true" aria-controls="ICTGraph">
            <i class="fas fa-chevron-down text-dark fa-rotate-180"></i>
        </button>
    </div>
    <div id="ICTGraph" class="collapse show" aria-labelledby="ICTGraphHeading">
        <div class="card-body">
            <canvas id="IctChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width:100%;"></canvas>
        </div>
    </div>
</div>
<hr>










    </div>

@endsection

@section('script')

<!-- JavaScript (ทำให้ไอคอนหมุนตามสถานะ) -->
<script>
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function () {
            const icon = this.querySelector('i'); // เลือกไอคอนภายในปุ่ม
            icon.classList.toggle('fa-rotate-180'); // สลับคลาสหมุน 180 องศา
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
        // ดึงข้อมูลจาก Blade ไปใส่ใน JavaScript
        const provincesRaw = @json($provinces);
        const fttxNew = @json($fttxNew);
        const selfInstall = @json($selfInstall);
        const hireInstall = @json($HireInstall);

        // กรองข้อมูล: ไม่เอา provinces ที่ทุกค่า (fttxNew, selfInstall, hireInstall) เท่ากับ 0
        const filteredData = provincesRaw.filter((province) => {
            const provinceId = province.province_id;
            return (
                (fttxNew[provinceId] || 0) > 0 ||
                (selfInstall[provinceId] || 0) > 0 ||
                (hireInstall[provinceId] || 0) > 0
            );
        });

        // สร้างข้อมูลที่ผ่านการกรอง
        const provinces = filteredData.map((province) => province.province_name);
        const fttxData = filteredData.map((province) => fttxNew[province.province_id] || 0);
        const selfInstallData = filteredData.map((province) => selfInstall[province.province_id] || 0);
        const hireInstallData = filteredData.map((province) => hireInstall[province.province_id] || 0);

        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: provinces,
                datasets: [{
                        label: "จ้างผู้รับเหมา",
                        data: hireInstallData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        barThickness: 20,
                        borderRadius: 5,
                        categoryPercentage: 0.8, // กำหนดให้แท่งมีช่องว่าง
                        barPercentage: 1.0, // ใช้แท่งทั้งหมดที่มี
                    },
                    {
                        label: "NEW",
                        data: fttxData,
                        backgroundColor: 'rgba(54, 162, 235, 0.45)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barThickness: 20,
                        borderRadius: 5,
                        categoryPercentage: 0.8,
                        barPercentage: 1.0,
                    },
                    {
                        label: "ติดตั้งเอง",
                        data: selfInstallData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        barThickness: 20,
                        borderRadius: 5,
                        categoryPercentage: 0.8,
                        barPercentage: 1.0,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom', // ย้าย Legend มาด้านล่าง
                        labels: {
                            font: {
                                size: 12,
                            },
                        },
                    },
                    datalabels: {
                        display: true,
                        color: '#fff',
                        backgroundColor: 'rgba(0,0,0,0.5)',
                        borderRadius: 3,
                        anchor: 'end',
                        offset: -15,
                        align: 'top',
                        formatter: (value) => {
                            return value > 0 ? value : null;
                        },
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false, // ซ่อนเส้น Grid
                        },
                        ticks: {
                            font: {
                                size: 12,
                            },
                            maxRotation: 45,
                            minRotation: 0,
                        },
                        title: {
                            display: true,
                            text: 'จังหวัด', // เพิ่มชื่อแกน X
                            font: {
                                size: 16,
                                weight: 'bold',
                            },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'จำนวนการติดตั้ง', // เพิ่มชื่อแกน Y
                            font: {
                                size: 16,
                                weight: 'bold',
                            },
                        },
                    },
                },
            },
            plugins: [ChartDataLabels],
        });
    </script>

    <script>
        // เตรียมข้อมูลจาก PHP
        const simProvinces = @json($provinces);
        const simNewData = @json($Simmy_new);
        const simMoveData = @json($Simmy_move);
        const simCountData = @json($Simmy_count);

        // สร้างอาร์เรย์สำหรับ Bar และ Line chart
        const labels = simProvinces.map(province => province.province_name);
        const newCustomers = simProvinces.map(province => simNewData[province.province_id] || 0);
        const moveCustomers = simProvinces.map(province => simMoveData[province.province_id] || 0);
        const counts = simProvinces.map(province => simCountData[province.province_id] || 0);

        // เปลี่ยนชื่อ config เป็น simMyChartConfig
        const simMyChartConfig = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        type: 'bar', // Bar สำหรับลูกค้าใหม่
                        label: 'ลูกค้าใหม่',
                        data: newCustomers,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(70, 192, 192, 1)',
                        borderWidth: 1,
                        order: 1 // ลำดับของ Bar จะต่ำกว่า Line
                    },
                    {
                        type: 'line', // Line สำหรับลูกค้าย้ายค่าย
                        label: 'ลูกค้า (ย้ายค่าย)',
                        data: moveCustomers,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        tension: 0.4, // เพิ่มความยืดหยุ่นให้เส้นเพื่อให้มันดูมีระยะห่าง
                        fill: false, // ไม่เติมสีใต้เส้น
                        pointRadius: 5, // เพิ่มขนาดจุดเพื่อให้เห็นชัดขึ้น
                        pointHoverRadius: 7, // ขนาดของจุดเมื่อ hover
                        order: 2 // ให้ Line อยู่เหนือ Bar
                    },
                    {
                        type: 'line', // Line สำหรับจำนวนราย
                        label: 'จำนวน (ราย)',
                        data: counts,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.4, // เพิ่มความยืดหยุ่นให้เส้น
                        fill: false,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        order: 3 // ให้ Line อยู่เหนือ Bar
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'จังหวัด'
                        },
                        ticks: {
                            autoSkip: false, // กำหนดให้ไม่แสดงทุก label ถ้ามีข้อมูลมาก
                        },
                        grid: {
                            display: true,
                            drawBorder: true
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'จำนวนลูกค้า'
                        },
                        beginAtZero: true,

                    }
                }
            }
        };


        // แก้ไขในส่วนที่สอง
        const simCtx = document.getElementById('simMyChart').getContext('2d');
        // เรนเดอร์กราฟ
        new Chart(simCtx, simMyChartConfig);
    </script>


    <script>
        // ดึงข้อมูลจาก Blade ไปใส่ใน JavaScript
        const Ictprovinces = @json($provinces);
        const ictCount = @json($Ict_count); // ข้อมูล ICT Count
        const ictIncome = @json($Ict_income); // ข้อมูล ICT Income

        // กรองข้อมูล: ไม่เอา provinces ที่ทุกค่า (Ict_count, Ict_income) เท่ากับ 0
        const ictdata = Ictprovinces.filter((province) => {
            const provinceId = province.province_id;
            return (
                (ictCount[provinceId] || 0) > 0 ||
                (ictIncome[provinceId] || 0) > 0
            );
        });

        // สร้างข้อมูลที่ผ่านการกรอง
        const provinces1 = ictdata.map((province) => province.province_name);
        const ictCountData = ictdata.map((province) => ictCount[province.province_id] || 0);
        const ictIncomeData = ictdata.map((province) => ictIncome[province.province_id] || 0);

        const ctx1 = document.getElementById('IctChart').getContext('2d');

        const myChart3 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: provinces1, // ใช้ provinces1 แทน provinces
                datasets: [{
                    label: "รายได้",
                    data: ictIncomeData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: 20,
                    borderRadius: 5,
                    categoryPercentage: 0.8,
                    barPercentage: 1.0,
                }, ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom', // ย้าย Legend มาด้านล่าง
                        labels: {
                            font: {
                                size: 12,
                            },
                        },
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            // ใช้ custom tooltip
                            label: function(tooltipItem) {
                                const provinceIndex = tooltipItem.dataIndex; // เอาตำแหน่งข้อมูลที่คลิก
                                const provinceName = provinces1[provinceIndex];
                                const ictCountValue = ictCountData[
                                provinceIndex]; // ใช้ ictCountData ที่ตรงกับ province
                                const ictIncomeValue = ictIncomeData[
                                provinceIndex]; // ใช้ ictIncomeData ที่ตรงกับ province

                                // แสดงข้อมูลใน Tooltip
                                return ` จำนวน ${ictCountValue} ราย  / รายได้ ${ictIncomeValue}`;
                            },
                        },
                    },
                    datalabels: {
                        display: true,
                        color: '#fff',
                        backgroundColor: 'rgba(0,0,0,0.5)',
                        borderRadius: 3,
                        anchor: 'end',
                        offset: -15,
                        align: 'top',
                        formatter: (value) => {
                            return value > 0 ? value : null;
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false, // ซ่อนเส้น Grid
                        },
                        ticks: {
                            font: {
                                size: 12,
                            },
                            maxRotation: 45, // มุมการหมุนของป้ายแกน X
                            minRotation: 0,
                        },
                        title: {
                            display: true,
                            text: 'จังหวัด', // เพิ่มชื่อแกน X
                            font: {
                                size: 16,
                                weight: 'bold',
                            },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: ' รายได้', // เพิ่มชื่อแกน Y
                            font: {
                                size: 16,
                                weight: 'bold',
                            },
                        },
                    },
                },
            },
            plugins: [ChartDataLabels],
        });
    </script>




    <script>
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
