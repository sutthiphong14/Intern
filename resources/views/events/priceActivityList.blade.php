@extends('admins.index')
@section('css')
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
        <a href="javascript:history.back(-3)" class="">
        ข้อมูลพื้นฐานบริการ
        </a>
        /
        <a href="javascript:history.back(-2)" class="">
        ข้อมูลพื้นฐานโปรโมชัน
        </a>
        /
        <a href="javascript:history.back()" class="">
        ข้อมูลพื้นฐานความเร็ว
        </a>
        /
        </span>
        ข้อมูลพื้นฐานราคา
</h4>
<div class="content-wrapper">
<div class="card">

<div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">ข้อมูลพื้นฐานราคา</h3>
                <div class="d-flex align-items-center gap-2">

                    <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-success " data-bs-toggle="modal" data-bs-target="#PriceModal">เพิ่มราคา</button>
                        <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal"
                            data-bs-target="#modalScrollable">
                            <i class="fas fa-question-circle"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
            <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ราคา</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>

                            <td>{{ $row->price_name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPriceModal"
                                    data-url="{{ route('price_update', ['service_id' => $service_id, 'promotion_id' => $promotion_id,'speed_id' => $speed_id, 'price_id' => $row->price_id]) }}"
                                    data-id="{{ $row->price_id }}" data-name="{{ $row->price_name }}">
                                    แก้ไข
                                </button>
                                <form
                                    action="{{ route('price_delete',  ['service_id' => $service_id, 'promotion_id' => $promotion_id,'speed_id' => $speed_id, 'price_id' => $row->price_id]) }}"
                                    method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-url="{{ route('price_delete',  ['service_id' => $service_id, 'promotion_id' => $promotion_id,'speed_id' => $speed_id, 'price_id' => $row->price_id]) }}"
                                        onclick="showDeleteConfirm(event)">
                                        ลบ
                                    </button>
                            </td>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลราคา</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="PriceModal" tabindex="-1" aria-labelledby="PriceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="priceForm" action="{{ route('price_insert', ['service_id' => $service_id, 'promotion_id' => $promotion_id,'speed_id' => $speed_id]) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="PriceModalLabel">เพิ่มราคา</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="price_name" class="form-label">จำนวนราคา</label>
                                <input type="number" class="form-control" id="price_name" name="price_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal สำหรับแก้ไข -->
        <div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPriceModalLabel">แก้ไขราคา</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editPriceForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="priceName" class="form-label">จำนวนราคา</label>
                                <input type="number" class="form-control" id="priceName" name="price_name" required>
                            </div>
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
    </div>
    </div>
    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                    timerProgressBar: true,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editPriceModal = document.getElementById('editPriceModal');
            editPriceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const rate = button.getAttribute('data-rate');

                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editPriceForm');
                form.action = url;
                form.querySelector('#priceName').value = name;
            });
        });
    </script>

    <script>
        function showDeleteConfirm(event) {
            event.preventDefault(); // หยุดการ reload หน้า
            const form = event.target.closest('form'); // หาฟอร์มที่เกี่ยวข้อง

            Swal.fire({
                title: 'ลบข้อมูลหรือไม่?',
                text: "คุณจะไม่สามารถย้อนกลับได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ทำการส่งฟอร์ม
                }
            });
        }
    </script>
@endsection
