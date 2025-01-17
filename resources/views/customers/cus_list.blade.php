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
                    <th>(จังหวัด/ศูนย์บริการ/อื่นๆ)</th>
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
                                @if (is_null($customer->province) && is_null($customer->center) && is_null($customer->other))
                                    <span class="text-danger">ไม่ได้ระบุ</span>
                                @elseif (is_null($customer->province) && is_null($customer->center))
                                    <span class="text-warning">{{ $customer->other ?? 'N/A' }}</span>
                                @elseif (is_null($customer->other))
                                    {{ $customer->province->province_name ?? 'N/A' }} /
                                    {{ $customer->center->center_name ?? 'N/A' }}
                                @else
                                    {{ $customer->province->province_name ?? 'N/A' }} /
                                    {{ $customer->center->center_name ?? 'N/A' }}
                                @endif
                            </td>


                            <td>
                                <a href="{{ route('customer_edit', $customer->cus_id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                    <form id="deleteForm{{ $customer->cus_id }}" action="{{ route('customer_delete', $customer->cus_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $customer->cus_id }})">Delete</button>
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
                        <td colspan="12" class="text-center">No Customer Data</td>
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
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">โปรโมชั่น:</span>
                                {{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ความเร็ว:</span>
                                {{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</p>
                            <p><span class="fw-bold text-dark">ราคา:</span> {{ $customer->price->price_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">จังหวัด:</span>
                                @if (is_null($customer->province) && is_null($customer->center))
                                    ไม่ระบุ
                                @else
                                    {{ $customer->province->province_name ?? 'ไม่ระบุ' }}
                                @endif
                            </p>
                            <p><span class="fw-bold text-dark">ศูนย์บริการ:</span>
                                @if (is_null($customer->province) && is_null($customer->center))
                                    ไม่ระบุ
                                @else
                                    {{ $customer->center->center_name ?? 'ไม่ระบุ' }}
                                @endif
                            </p>
                            <p><span class="fw-bold text-dark">อื่นๆ:</span> {{ $customer->other ?? 'ไม่ระบุ' }}</p>

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
