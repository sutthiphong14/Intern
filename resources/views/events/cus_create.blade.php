@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">

        <form action="{{ route('customer_insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php
                // จัดเรียงรายการให้ 'ร่วม' ขึ้นก่อน
                $sortedServices = $services->sortByDesc(
                    fn($service) => strpos($service->service_name, 'ร่วม') !== false,
                );
            @endphp
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="m-0">เพิ่มลูกค้า</h2>

                <div class="mt-3">
                    <p class="mb-2 text-danger">* เลือกบริการ</p>
                    <select class="form-select bg-success" id="service_id" name="service_id" required>
                        @foreach ($sortedServices as $service)
                            <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
                        @endforeach
                    </select>
                    <!-- เพิ่มข้อความคำแนะนำ หรือข้อผิดพลาดได้ -->
                    @error('service_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            @error('service_id')
                <small style="color:red">{{ $message }}</small>
            @enderror

            <div class="mb-3">
                <!-- Fullname -->
                <label for="cus_fullname" class="form-label" id="fullname_label">ชื่อ นามสกุล</label>
                @error('cus_fullname')
                    <p style="color:red">{{ $message }}</p>
                @enderror
                <input type="text" class="form-control" id="cus_fullname" name="cus_fullname"
                    value="{{ old('cus_fullname') }}" required>

                <div id="groupNet1">
                    <!-- ID Card -->
                    <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                    <input type="text" class="form-control" id="id_card" name="id_card" value="{{ old('id_card') }}"
                        required oninput="validateIdCard()">
                    <p id="error-id_card" style="color:red"></p>


                    <!-- Photo -->
                    <label for="cus_photo" class="form-label">รูปภาพ</label>
                    <input type="file" class="form-control" id="cus_photo" name="cus_photo" required>
                </div>

                {{-- ict_solution --}}
                <div id="ict_solution1">
                    <label for="customer_type" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-control" id="customer_type" name="customer_type" required>
                        <option value="" disabled selected>-- เลือกหน่วยงาน --</option>
                        <option value="หน่วยงานรัฐบาล">หน่วยงานรัฐบาล</option>
                        <option value="หน่วยงานเอกชน">หน่วยงานเอกชน</option>
                        <option value="หน่วยงานทั่วไป">หน่วยงานทั่วไป</option>
                    </select>


                    <!-- Photo -->
                    <label for="quote" class="form-label">ใบเสนอราคา (รูปภาพ/pdf.)</label>
                    <input type="file" class="form-control" id="quote" name="quote" required>
                    <p id="file-error" style="color:red; display:none;">กรุณาเลือกไฟล์ที่ถูกต้อง (รูปภาพหรือ PDF)</p>
                </div>



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



                <div id="groupNet">
                    <!-- Promotion -->
                    <label for="promotion_id" class="form-label">โปรโมชั่น</label>
                    <select class="form-select" id="promotion_id" name="promotion_id" required>
                        <option value="" disabled selected>-- เลือกโปรโมชั่น --</option>
                    </select>


                    <!-- Speed -->
                    <label for="speed_id" class="form-label">ความเร็ว</label>
                    <select class="form-select" id="speed_id" name="speed_id" required>
                        <option value="" disabled selected>-- เลือกความเร็ว --</option>
                    </select>

                    <!-- Price -->
                    <label for="price_id" class="form-label">ราคา</label>
                    <select class="form-select" id="price_id" name="price_id" required>
                        <option value="" disabled selected>-- เลือกราคา --</option>
                    </select>

                </div>
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

                {{-- ict_solution --}}
                <div id="ict_solution">
                    <div id="product-container">
                        <div class="d-flex product-row">
                            <div>
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-select" id="product_id" name="product_id[]" required>
                                    <option value="" disabled selected>-- เลือกProduct --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="quantity" class="form-label">จำนวน</label>
                                <input type="number" id="quantity_id" name="quantity[]" class="form-control"
                                    placeholder="ระบุจำนวน" required>
                            </div>
                            <button type="button" class="btn btn-success add-product mt-4">+</button>
                        </div>
                    </div>

                    <label for="income" class="form-label">รายได้</label>
                    <input type="number" id="income" name='income' class="form-control bg-warning" required>
                </div>

                <!-- fttx_broadband form-->
                <div id="fttx_broadband">
                    <label for="new" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="new" name="new" required>
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
                    <label for="cus_new" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="cus_new" name="cus_new" required>
                        <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                        <option value="1" class="bg-secondary"> ลูกค้าใหม่ </option>
                        <option value="0" class="bg-secondary"> ลูกค้า(ย้ายค่าย) </option>
                    </select>
                </div>

                <!-- Date Form -->
                <div id="date" class="mt-3">
                    <label for="date" class="form-label">วัน/เดือน/ปี</label>
                    <input type="date" id="date" name="date" class="form-label" required
                        value="<?= date('Y-m-d') ?>">
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
        document.getElementById("date").valueAsDate = new Date();
    </script>
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
        document.getElementById("quote").addEventListener("change", function() {
            var file = this.files[0];
            var errorMessage = document.getElementById("file-error");
            var saveButton = document.getElementById("save-button");

            if (file) {
                var fileType = file.type;
                var validTypes = ["image/jpeg", "image/png", "application/pdf"];

                if (!validTypes.includes(fileType)) {
                    errorMessage.textContent = "กรุณาเลือกไฟล์ที่ถูกต้อง (รูปภาพหรือ PDF)";
                    errorMessage.style.display = "block";
                    saveButton.disabled = true; // ทำให้ปุ่ม "Save" ไม่สามารถกดได้
                } else {
                    errorMessage.style.display = "none";
                    saveButton.disabled = false; // ทำให้ปุ่ม "Save" สามารถกดได้
                }
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



    <script>
        $(document).ready(function() {
            function toggleForms(serviceName) {
                if (serviceName.includes('fttx_broadband')) {
                    $('#fttx_broadband,#groupNet, #groupNet1').show();
                    $('#sim_my, #ict_solution, #ict_solution1').hide();

                    // เปิด required สำหรับฟอร์ม fttx_broadband
                    $('#new, #installation_type').prop('required', true);
                    // กลับ label เป็น "ชื่อ นามสกุล"
                    $('#fullname_label').text('ชื่อ นามสกุล');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#cus_new, #income, #customer_type, #quote, #product_id, #quantity_id ').prop('required',
                        false);
                } else if (serviceName.includes('SIM my')) {
                    $('#sim_my,#groupNet, #groupNet1').show();
                    $('#fttx_broadband, #ict_solution, #ict_solution1').hide();

                    // เปิด required สำหรับฟอร์ม sim_my
                    $('#cus_new').prop('required', true);

                    // กลับ label เป็น "ชื่อ นามสกุล"
                    $('#fullname_label').text('ชื่อ นามสกุล');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#new, #installation_type, #income, #customer_type, #quote, #product_id, #quantity_id').prop(
                        'required', false);
                } else if (serviceName.includes('ICT solution')) {
                    $('#ict_solution, #ict_solution1').show();
                    $('#fttx_broadband, #sim_my, #groupNet, #groupNet1').hide();

                    // เปิด required สำหรับฟิลด์ income
                    $('#income').prop('required', true);
                    // เปลี่ยน label เป็น "ชื่อ/ชื่อหน่วยงาน"
                    $('#fullname_label').text('ชื่อ/ชื่อหน่วยงาน');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#new, #installation_type, #cus_new, #promotion_id, #speed_id, #price_id, #id_card, #cus_photo')
                        .prop('required',
                            false);
                } else {
                    // ซ่อนฟอร์มทั้งหมด
                    $('#fttx_broadband, #sim_my, #ict_solution, #ict_solution1').hide();

                    // ปิด required สำหรับทุกฟอร์ม
                    $('#new, #installation_type, #cus_new, #income, #customer_type, #quote , #product_id, #quantity_id')
                        .prop('required', false);
                    // กลับ label เป็น "ชื่อ นามสกุล"
                    $('#fullname_label').text('ชื่อ นามสกุล');
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("product-container");

            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("add-product")) {
                    const newRow = event.target.closest(".product-row").cloneNode(true);
                    newRow.querySelector("select").value = "";
                    newRow.querySelector("input").value = "";
                    newRow.querySelector(".add-product").classList.replace("btn-success", "btn-danger");
                    newRow.querySelector(".add-product").textContent = "-";
                    newRow.querySelector(".add-product").classList.replace("add-product", "remove-product");
                    container.appendChild(newRow);
                }

                if (event.target.classList.contains("remove-product")) {
                    event.target.closest(".product-row").remove();
                }
            });
        });
    </script>
@endsection
