@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>แก้ไขข้อมูลลูกค้า</h2>
        <form action="{{ route('customer_update', $customer->cus_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method for updating data -->
            <div class="mb-3">
                <label for="cus_fullname" class="form-label">ชื่อ นามสกุล</label>
                <input type="text" class="form-control" id="cus_fullname" name="cus_fullname" value="{{ $customer->cus_fullname }}" required>

                <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card" value="{{ $customer->id_card }}" required>

                <label for="cus_photo" class="form-label">รูปภาพ</label>
                <input type="file" class="form-control" id="cus_photo" name="cus_photo">

                <label for="cus_address" class="form-label">ที่อยู่</label>
                <textarea class="form-control" id="cus_address" name="cus_address" rows="4" required>{{ $customer->cus_address }}</textarea>

                <!-- Dropdown for Type -->
                <label for="type_id" class="form-label">กิจกรรม</label>
                <select class="form-select" id="type_id" name="type_id" required>
                    <option value="" disabled>-- เลือกกิจกรรม --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->type_id }}" {{ $customer->type_id == $type->type_id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                    @endforeach
                </select>

                <!-- Dropdown for Service -->
                <label for="service_id" class="form-label">บริการ</label>
                <select class="form-select" id="service_id" name="service_id" required>
                    <option value="" disabled>-- เลือกบริการ --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_id }}" {{ $customer->service_id == $service->service_id ? 'selected' : '' }}>{{ $service->service_name }}</option>
                    @endforeach
                </select>

                <!-- Dropdown for Province -->
                <label for="province_id" class="form-label">จังหวัด</label>
                <select class="form-select" id="province_id" name="province_id" required>
                    <option value="" disabled>-- เลือกจังหวัด --</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->province_id }}" {{ $customer->province_id == $province->province_id ? 'selected' : '' }}>{{ $province->province_name }}</option>
                    @endforeach
                </select>

                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
            </div>
            <button type="submit" class="btn btn-success">บันทึก</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">ย้อนกลับ</a>
        </form>
    </div>
@endsection
