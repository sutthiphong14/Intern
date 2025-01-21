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
                <input type="text" class="form-control" id="cus_fullname" name="cus_fullname"
                    value="{{ $customer->cus_fullname }}" required>

                <!-- ID Card -->
                <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card" value="{{ $customer->id_card }}"
                    oninput="validateIdCard()" required>
                <p id="error-id_card" style="color:red"></p>

                <label for="cus_photo" class="form-label">รูปภาพ</label>
                <input type="file" class="form-control" id="cus_photo" name="cus_photo"
                    value="{{ $customer->cus_photo }}" required>
                <p id="error-cus_photo" style="color:red"></p>

                <label for="cus_address" class="form-label">ที่อยู่</label>
                <textarea class="form-control" id="cus_address" name="cus_address" rows="4" required>{{ $customer->cus_address }}</textarea>

                <!-- Dropdown for Type -->
                <label for="type_id" class="form-label">กิจกรรม</label>
                <select class="form-select" id="type_id" name="type_id" required>
                    <option value="" disabled>-- เลือกกิจกรรม --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->type_id }}" {{ $customer->type_id == $type->type_id ? 'selected' : '' }}>
                            {{ $type->type_name }}</option>
                    @endforeach
                </select>

                <!-- Dropdown for Service -->
                <label for="service_id" class="form-label">บริการ</label>
                <select class="form-select" id="service_id" name="service_id" required>
                    <option value="" disabled>-- เลือกบริการ --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_id }}"
                            {{ $customer->service_id == $service->service_id ? 'selected' : '' }}>
                            {{ $service->service_name }}</option>
                    @endforeach
                </select>

                <label for="promotion_id" class="form-label">โปรโมชั่น</label>
                <select class="form-select" id="promotion_id" name="promotion_id" required>
                    @foreach ($promotion as $promotion)
                        <option value="{{ $promotion->promotion_id }}"
                            {{ $customer->promotion_id == $promotion->promotion_id ? 'selected' : '' }}>
                            {{ $promotion->promotion_name }}</option>
                    @endforeach
                </select>

                <label for="speed_id" class="form-label">ความเร็ว</label>
                <select class="form-select" id="speed_id" name="speed_id" required>
                    @foreach ($speed as $speed)
                        <option value="{{ $speed->speed_id }}"
                            {{ $customer->speed_id == $speed->speed_id ? 'selected' : '' }}>{{ $speed->speed_name }}
                        </option>
                    @endforeach
                </select>

                <label for="price_id" class="form-label">ราคา</label>
                <select class="form-select" id="price_id" name="price_id" required>
                    @foreach ($prices as $prices)
                        <option value="{{ $prices->price_id }}"
                            {{ $customer->prices_id == $prices->price_id ? 'selected' : '' }}>{{ $prices->price_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Dropdown for Province -->
                <label for="province_id" class="form-label">จังหวัด</label>
                <select class="form-select" id="province_id" name="province_id" required>
                    <option value="" disabled>-- เลือกจังหวัด--</option>

                    @foreach ($provinces as $province)
                        <option value="{{ $province->province_id }}"
                            {{ $customer->province_id == $province->province_id ? 'selected' : '' }}>
                            {{ $province->province_name }}
                        </option>
                    @endforeach
                </select>

                <!-- Dropdown for Center -->
                <label for="center_id" class="form-label">ศูนย์บริการ</label>
                <select class="form-select" id="center_id" name="center_id">
                    <option value="" disabled>--เลือกศูนย์บริการ --</option>
                    @foreach ($centers as $center)
                        <option value="{{ $center->center_id }}"
                            {{ $customer->center_id == $center->center_id ? 'selected' : '' }}>
                            {{ $center->center_name }}
                        </option>
                    @endforeach
                </select>


                <label for="other" class="form-label">หมายเหตุ</label>
                <textarea class="form-control" id="other" name="other" rows="4">{{ $customer->other }}</textarea>

                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
            </div>
            <button type="submit" class="btn btn-success" id="save-button">บันทึก</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">ย้อนกลับ</a>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#service_id').change(function() {
                var serviceId = $(this).val(); // เก็บค่า service_id ที่เลือก

                // ส่งค่าไปเซิร์ฟเวอร์เพื่อตรวจสอบโปรโมชั่น
                $.ajax({
                    url: '/getPromotions', // เส้นทางที่ส่งคำขอ (Route)
                    type: 'GET',
                    data: {
                        service_id: serviceId
                    },
                    success: function(data) {
                        $('#promotion_id').empty(); // ล้างตัวเลือกเก่าออก
                        $('#promotion_id').append(
                            '<option value="" disabled selected>-- เลือกโปรโมชั่น --</option>'
                        );
                        $.each(data, function(index, promotion) {
                            $('#promotion_id').append('<option value="' + promotion
                                .promotion_id + '">' + promotion.promotion_name +
                                '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error fetching promotions');
                    }
                });
            });

            // การดึงข้อมูลอื่นๆ (เช่น Speed, Price) ก็สามารถทำคล้ายๆ กันได้
        });

        $('#promotion_id').change(function() {
            var promotionId = $(this).val();

            $.ajax({
                url: '/getSpeeds',
                type: 'GET',
                data: {
                    promotion_id: promotionId
                },
                success: function(data) {
                    $('#speed_id').empty();
                    $('#speed_id').append(
                        '<option value="" disabled selected>-- เลือกความเร็ว --</option>');
                    $.each(data, function(index, speed) {
                        $('#speed_id').append('<option value="' + speed.speed_id + '">' + speed
                            .speed_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching speeds');
                }
            });
        });


        $('#speed_id').change(function() {
            var speedId = $(this).val();

            $.ajax({
                url: '/getPrices',
                type: 'GET',
                data: {
                    speed_id: speedId
                },
                success: function(data) {
                    $('#price_id').empty();
                    $('#price_id').append(
                        '<option value="" disabled selected>-- เลือกราคา --</option>');
                    $.each(data, function(index, price) {
                        $('#price_id').append('<option value="' + price.price_id + '">' + price
                            .price_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching prices');
                }
            });
        });


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
                        $('#center_id').append('<option value="' + center.center_id + '">' +
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
        document.getElementById('cus_photo').addEventListener('change', function() {
            const file = this.files[0];
            const errorElement = document.getElementById('error-cus_photo');
            const saveButton = document.getElementById('save-button');

            if (file && ['image/jpeg', 'image/png'].includes(file.type)) {
                errorElement.textContent = '';
                saveButton.disabled = false;
            } else {
                errorElement.textContent = 'กรุณาอัปโหลดไฟล์รูปภาพที่ถูกต้อง (JPEG หรือ PNG)';
                saveButton.disabled = true;
            }
        });
    </script>

<script>
    function validateIdCard() {
        const idCard = document.getElementById('id_card').value;
        const errorMessage = document.getElementById('error-id_card');

        // Regex to check if it's 13 digits long
        const regex = /^\d{13}$/;
        if (!regex.test(idCard)) {
            errorMessage.textContent = 'หมายเลขบัตรประชาชนต้องเป็น 13 หลัก!';
        } else {
            errorMessage.textContent = '';
        }
    }
</script>
@endsection
