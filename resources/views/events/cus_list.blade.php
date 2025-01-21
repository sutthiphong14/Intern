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
                            <p><span class="fw-bold text-dark">ประเภท:</span> {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">บริการ:</span>
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }} <a
                                    class="btn btn-warning btn-sm text-dark" data-bs-toggle="modal"
                                    data-bs-target="#fttxBroadbandModal{{ $customer->cus_id }}">ดูบริการ</a></p>
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
                            <h5 class="modal-title" id="fttxBroadbandLabel{{ $customer->cus_id }}">ข้อมูลบริการของลูกค้า </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- ดึงข้อมูลจาก fttx_broadband -->
                            <p><span class="fw-bold text-dark">บริการ:</span> {{ $customer->service->service_name }} </p>
                            @php
                                $fttxData = \App\Models\Fttxbroadband::where('cus_id', $customer->cus_id)->first();
                            @endphp

                            @if ($fttxData)
                                <p><span class="fw-bold text-dark">งานติดตั้ง:</span>
                                    {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
                                </p>
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span>
                                    {{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : 'ปรับโปรโมชั่น' }}</p>
                            @else
                                <p><span class="fw-bold text-dark">วิธีการติดตั้ง:</span> ไม่ระบุ</p>
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span> ไม่ระบุ</p>
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
                   
                    <th rowspan="2" >new</th>
                    <th rowspan="2">ติดตั้งเอง</th>
                    <th rowspan="2">จ้างผู้รับเหมา</th>
                    
                </tr>
            </thead>
            <tbody class="text-center">
                <td>1</td>
                <td>ขอนแก่่น</td>
                <td>5</td>
                <td>10</td>
                <td>50</td>
            </tbody>
        </table>
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
@endsection
