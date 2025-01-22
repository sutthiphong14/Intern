@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>จัดการลูกค้า</h2>
        <a href="{{ route('customer_create') }}" class="btn btn-primary mb-3">เพิ่มข้อมูลลูกค้า</a>
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
            <tbody>
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


                            <td>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><span class="fw-bold text-dark">รหัสลูกค้า:</span> {{ $customer->cus_id }}</p>
                            <p><span class="fw-bold text-dark">ชื่อ-นามสกุล:</span> {{ $customer->cus_fullname }}</p>
                            <p><span class="fw-bold text-dark">รหัสบัตรประชาชน:</span> {{ $customer->id_card }}</p>
                            <p><span class="fw-bold text-dark">ที่อยู่:</span> {{ $customer->cus_address }}</p>
                            <p><span class="fw-bold text-dark">กิจกรรม:</span>
                                {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">บริการ:</span>
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }} <a
                                    class="btn btn-warning btn-sm text-dark" data-bs-toggle="modal"
                                    data-bs-target="#fttxBroadbandModal{{ $customer->cus_id }}">รายละเอียด</a></p>
                            <p><span class="fw-bold text-dark">โปรโมชั่น:</span>
                                {{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ความเร็ว:</span>
                                {{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ราคา:</span> {{ $customer->price->price_name ?? 'ไม่ระบุ' }}
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

        <!-- Modal สำหรับดูข้อมูลใน fttx_broadband -->
        @foreach ($data as $customer)
            <div class="modal fade" id="fttxBroadbandModal{{ $customer->cus_id }}" tabindex="-1"
                aria-labelledby="fttxBroadbandLabel{{ $customer->cus_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="fttxBroadbandLabel{{ $customer->cus_id }}">ข้อมูลบริการของลูกค้า
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- ดึงข้อมูลจาก fttx_broadband -->
                            <p><span class="fw-bold text-dark">บริการ:</span> {{ $customer->service->service_name }} </p>
                            @php
                                $fttxData = \App\Models\Fttxbroadband::where('cus_id', $customer->cus_id)->first();
                            @endphp

                            @if ($fttxData)
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span>
                                    {{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : 'ปรับโปรโมชั่น' }}</p>
                                <p><span class="fw-bold text-dark">งานติดตั้ง:</span>
                                    {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
                                </p>
                            @else
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span> ไม่ระบุ</p>
                                <p><span class="fw-bold text-dark">วิธีการติดตั้ง:</span> ไม่ระบุ</p>
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
        <h5>Fttx broadband</h5>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="2">ลำดับ</th>
                    <th rowspan="2">จังหวัด</th>
                    <th colspan="3">FTTX</th>

                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="2">new</th>
                    <th rowspan="2">ติดตั้งเอง</th>
                    <th rowspan="2">จ้างผู้รับเหมา</th>

                </tr>
            </thead>
            @php
            $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0; // สำหรับ province_id <= 33
            $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0; // สำหรับ province_id > 33
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
                    </tr>
                    @php
                        $sumFttxNew += $fttxNew[$province->province_id] ?? 0;
                        $sumSelfInstall += $selfInstall[$province->province_id] ?? 0;
                        $sumHireInstall += $HireInstall[$province->province_id] ?? 0;
                    @endphp
                @endif
        
                {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                @if ($province->province_id == 12)
                    <tr class="bg-warning">
                        <td colspan="2" >รวม ตป.1</td>
                        <td>{{ $sumFttxNew }}</td>
                        <td>{{ $sumSelfInstall }}</td>
                        <td>{{ $sumHireInstall }}</td>
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
                    </tr>
                    @php
                        $sumFttxNewOver33 += $fttxNew[$province->province_id] ?? 0;
                        $sumSelfInstallOver33 += $selfInstall[$province->province_id] ?? 0;
                        $sumHireInstallOver33 += $HireInstall[$province->province_id] ?? 0;
                    @endphp
                @endif
            @endforeach
        
            {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
            <tr class="bg-warning">
                <td colspan="2" >รวม ตป.2</td>
                <td>{{ $sumFttxNewOver33 }}</td>
                <td>{{ $sumSelfInstallOver33 }}</td>
                <td>{{ $sumHireInstallOver33 }}</td>
            </tr>

            <tr class="bg-success">
                <td colspan="2" >รวม ทั้งหมด</td>
                <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
            </tr>
        </tbody>
        


        </table>
        <div class='card mt-5'>
            <h3 class="card-header bg-primary ">กราฟ Fttx broadband</h3>
            <canvas id="myChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
        </div>

    </div>

@endsection

@section('script')
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
                        barThickness: 33,

                    },
                    {
                        label: "NEW",
                        data: fttxData,
                        backgroundColor: 'rgba(54, 162, 235, 0.45)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        barThickness: 50,
                    },
                    {
                        label: "ติดตั้งเอง",
                        data: selfInstallData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        barThickness: 33,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    // ตั้งค่า Data Labels
                    datalabels: {
                        display: true,
                        color: '#000', // สีตัวอักษร
                        backgroundColor: '#28b463', // สีพื้นหลังของตัวหนังสือ (พร้อมความโปร่งใส)
                        borderColor: '#000',
                        anchor: 'end', // ตำแหน่งอ้างอิงให้อยู่ด้านบนของกราฟ
                        offset: 5, // ระยะห่างจากแท่งกราฟ
                        formatter: (value) => {
                            // ถ้าค่าเป็น 0 จะไม่แสดงข้อความ
                            return value > 0 ? value : null;
                        },
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                    },

                },
            },
            plugins: [ChartDataLabels], // ใช้ plugin datalabels
        });
    </script>
@endsection
