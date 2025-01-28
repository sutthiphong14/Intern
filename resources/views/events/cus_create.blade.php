@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>เพิ่มลูกค้า</h2>
        <form action="{{ route('customer_insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <!-- Fullname -->
                <label for="cus_fullname" class="form-label">ชื่อ นามสกุล</label>
                @error('cus_fullname')
                    <p style="color:red">{{ $message }}</p>
                @enderror
                <input type="text" class="form-control" id="cus_fullname" name="cus_fullname"
                    value="{{ old('cus_fullname') }}" required>

                <!-- ID Card -->
                <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                <input type="text" class="form-control" id="id_card" name="id_card" value="{{ old('id_card') }}"
                    required oninput="validateIdCard()">
                <p id="error-id_card" style="color:red"></p>


                <!-- Photo -->
                <label for="cus_photo" class="form-label">รูปภาพ</label>
                <input type="file" class="form-control" id="cus_photo" name="cus_photo" required>



                <!-- Address -->
                <label for="cus_address" class="form-label">ที่อยู่</label>
                <textarea class="form-control" id="cus_address" name="cus_address" rows="4" required>{{ old('cus_address') }}</textarea>
                @error('cus_address')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <!-- Type -->
                <label for="type_id" class="form-label">กิจกรรม</label>
                <select class="form-select" id="type_id" name="type_id" required>
                    <option value="" disabled selected>-- เลือกกิจกรรม --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->type_id }}">{{ $type->type_name }}</option>
                    @endforeach
                </select>
                @error('type_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Service -->
                <div class="d-flex justify-content-between">
                    <div class="w-100">
                        <label for="service_id" class="form-label">บริการ</label>
                        <select class="form-select w-100" id="service_id" name="service_id" required>
                            <option value="" disabled selected>-- เลือกบริการ --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-100 mt-4">
                        <a href="{{ route('service_list') }}" class="btn btn-primary ">เพิ่มบริการใหม่</a>
                    </div>
                </div>


                @error('service_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Promotion -->
                <label for="promotion_id" class="form-label">โปรโมชั่น</label>
                <select class="form-select" id="promotion_id" name="promotion_id" required>
                    <option value="" disabled selected>-- เลือกโปรโมชั่น --</option>
                </select>
                @error('promotion_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Speed -->
                <label for="speed_id" class="form-label">ความเร็ว</label>
                <select class="form-select" id="speed_id" name="speed_id" required>
                    <option value="" disabled selected>-- เลือกความเร็ว --</option>
                </select>
                @error('speed_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Price -->
                <label for="price_id" class="form-label">ราคา</label>
                <select class="form-select" id="price_id" name="price_id" required>
                    <option value="" disabled selected>-- เลือกราคา --</option>
                </select>
                @error('price_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Province -->
                <label for="province_id" class="form-label">จังหวัด</label>
                <select class="form-select" id="province_id" name="province_id" required>
                    <option value="" disabled selected>-- เลือกจังหวัด --</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                    @endforeach
                </select>
                @error('province_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- Center -->
                <label for="center_id" class="form-label">ศูนย์บริการ</label>
                <select class="form-select" id="center_id" name="center_id" required>
                    <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                </select>
                @error('center_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <!-- fttx_broadband form-->
                <div id="fttx_broadband">
                    <label for="cus_type_fttx" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="cus_type_fttx" name="cus_type_fttx" required>
                        <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                        <option value="1" class="bg-secondary"> ลูกค้าใหม่ </option>
                        <option value="0" class="bg-secondary"> ปรับโปรโมชั่น </option>
                    </select>
                    <label for="installation_type" class="form-label">งานติดตั้ง</label>
                    <select class="form-select bg-warning" id="installation_type" name="installation_type" required>
                        <option value="" disabled selected>-- เลือกวิธีการติดตั้ง --</option>
                        <option value="1" class="bg-secondary"> ติดตั้งเอง </option>
                        <option value="0" class="bg-secondary"> จ้างผู้รับเหมา </option>
                    </select>
                </div>

                <!-- sim_my form-->
                <div id="sim_my">
                    <label for="cus_type_sim" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="cus_type_sim" name="cus_type_sim" required>
                        <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                        <option value="1" class="bg-secondary"> ลูกค้าใหม่ </option>
                        <option value="0" class="bg-secondary"> ลูกค้า(ย้ายค่าย) </option>
                    </select>
                </div>

                <!-- Other -->
                <label for="other" class="form-label">หมายเหตุ</label>
                <textarea class="form-control" id="other" name="other" rows="4">{{ old('other') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success" id="save-button">Save</button>
            <a href="{{ route('customer_list') }}" class="btn btn-secondary">Back</a>
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


    <script>
        $(document).ready(function() {
            function toggleForms(serviceName) {
                if (serviceName === 'fttx_broadband') {
                    $('#fttx_broadband').show();
                    $('#sim_my').hide();

                    // เปิด required สำหรับฟอร์ม fttx_broadband
                    $('#cus_type_fttx, #installation_type').prop('required', true);

                    // ปิด required สำหรับฟอร์ม sim_my
                    $('#cus_type_sim').prop('required', false);
                } else if (serviceName.includes('SIM my')) {
                    $('#sim_my').show();
                    $('#fttx_broadband').hide();

                    // เปิด required สำหรับฟอร์ม sim_my
                    $('#cus_type_sim').prop('required', true);

                    // ปิด required สำหรับฟอร์ม fttx_broadband
                    $('#cus_type_fttx, #installation_type').prop('required', false);
                } else {
                    // ซ่อนฟอร์มทั้งหมด
                    $('#fttx_broadband, #sim_my').hide();

                    // ปิด required สำหรับทุกฟอร์ม
                    $('#cus_type_fttx, #installation_type, #cus_type_sim').prop('required', false);
                }
            }

            // เรียกใช้ฟังก์ชันตอนโหลดหน้า
            var serviceName = $('#service_id option:selected').text();
            toggleForms(serviceName);

            // เรียกใช้ฟังก์ชันเมื่อเลือก service_id ใหม่
            $('#service_id').change(function() {
                var serviceName = $(this).find('option:selected').text();
                toggleForms(serviceName);
            });
        });
    </script>
@endsection
