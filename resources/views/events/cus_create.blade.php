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
            <a href="javascript:history.back()" class="">
                ข้อมูลลูกค้า
            </a>
            /
        </span> ข้อมูลลูกค้า
    </h4>

    <div class="card mb-4">
        <div class="d-flex justify-content-between align-items-center gap-2">
            <h3 class="card-header text-dark">แบบฟอร์มข้อมูลลูกค้า</h3>
            <div class="d-flex align-items-center gap-2">
                <div class="form-group me-4">

                    <a href="{{ route('top_up_list', $type_id) }}" class="btn btn-warning col-auto">เติมเงินรายปี</a>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <form action="{{ route('customer_insert') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <label for="type_id" class="form-label">กิจกรรม <span style="color: red;">*</span> </label>
                <input type="text" class="form-control" id="type_id_display"
                    value="{{ $types->pluck('type_name')->implode(', ') }}" readonly>
                <input type="hidden" id="type_id" name="type_id" value="{{ $types->pluck('type_id')->implode(', ') }}">

                <label for="service_id" class="form-label mt-3">บริการ <span style="color: red;">*</span></label>
                <select class="form-select  " id="service_id" name="service_id" required>
                    <option value="" selected disabled>กรุณาเลือกบริการ</option>

                </select>
                <!-- เพิ่มข้อความคำแนะนำ หรือข้อผิดพลาดได้ -->
                @error('service_id')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror


                @error('service_id')
                    <small style="color:red">{{ $message }}</small>
                @enderror

                <div class="mb-3">
                    <!-- Fullname -->
                    <p id="service-alert" class="text-danger bg-light" style="display: none;">กรุณาเลือกบริการก่อน</p>
                    <label for="cus_fullname" class="form-label mt-3" id="fullname_label">ชื่อ นามสกุล <span
                            style="color: red;">*</span></label>
                    @error('cus_fullname')
                        <p style="color:red">{{ $message }}</p>
                    @enderror
                    <input type="text" class="form-control" id="cus_fullname" name="cus_fullname"
                        value="{{ old('cus_fullname') }}" required>

                    <div id="groupNet1">
                        <!-- ID Card -->
                        <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน <span
                                style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="id_card" name="id_card"
                            value="{{ old('id_card') }}" oninput="validateIdCard()">


                        <!-- Photo -->
                        <label for="cus_photo" class="form-label">รูปภาพ</label>
                        <input type="file" class="form-control" id="cus_photo" name="cus_photo">
                    </div>

                    {{-- ict_solution 1 --}}
                    <div id="ict_solution1">
                        <label for="customer_type" class="form-label">ประเภทลูกค้า</label>
                        <select class="form-control" id="customer_type" name="customer_type" required>
                            <option value="" disabled selected>-- เลือกหน่วยงาน --</option>
                            <option value="หน่วยงานรัฐบาล">หน่วยงานรัฐบาล</option>
                            <option value="หน่วยงานเอกชน">หน่วยงานเอกชน</option>
                            <option value="หน่วยงานทั่วไป">หน่วยงานทั่วไป</option>
                        </select>

                        <label for="ict_service" class="form-label">ประเภท ICT solution</label>
                        <select class="form-select" id="ict_service" name="ict_service" required>
                            <option value="" disabled selected>--เลือก ICT solution --</option>

                        </select>
                        {{-- ict_solution --}}
                        <div id="ict_solution">
                            <div id="product-container">
                                <div class="d-flex product-row">
                                    <div>
                                        <label for="product_id" class="form-label">Product</label>
                                        <select class="form-select" id="product_id" name="product_id[]" required>
                                            <option value="" disabled selected>-- เลือกProduct --</option>

                                        </select>
                                    </div>
                                    <div>
                                        <label for="quantity" class="form-label">จำนวน</label>
                                        <input type="number" id="quantity_id" name="quantity[]" class="form-control"
                                            placeholder="ระบุจำนวน" required>
                                    </div>
                                    <div>
                                        <label for="quantity" class="form-label">ราคา</label>
                                        <input type="number" id="ICTprice_id" name="ICTprice[]" class="form-control"
                                            placeholder="ระบุจำนวน" required>
                                    </div>
                                    <button type="button" class="btn btn-success add-product mt-4">+</button>
                                </div>
                            </div>
                          
                        </div>
                        <label for="income" class="form-label">รายได้ต่อเดือน</label>
                        <input type="number" id="income" name='income' class="form-control bg-warning" required>
                          <!-- Photo -->
                          <label for="quote" class="form-label">ใบเสนอราคา (รูปภาพ/pdf.)</label>
                          <input type="file" class="form-control" id="quote" name="quote" required>
                          <p id="file-error" style="color:red; display:none;">กรุณาเลือกไฟล์ที่ถูกต้อง (รูปภาพหรือ PDF)
                          </p>
                    </div>


                    <!-- Address -->
                    <label for="cus_address" class="form-label">ที่อยู่</label>
                    <textarea class="form-control" id="cus_address" name="cus_address" rows="4">{{ old('cus_address') }}</textarea>


                    <div id="groupNet">
                        <!-- Promotion -->
                        <label for="promotion_id" class="form-label">โปรโมชั่น <span style="color: red;">*</span></label>
                        <select class="form-select" id="promotion_id" name="promotion_id" required>
                            <option value="" disabled selected>-- เลือกโปรโมชั่น --</option>
                        </select>


                        <!-- Speed -->
                        <label for="speed_id" class="form-label">ความเร็ว <span style="color: red;">*</span></label>
                        <select class="form-select" id="speed_id" name="speed_id" required>
                            <option value="" disabled selected>-- เลือกความเร็ว --</option>
                        </select>

                        <!-- Price -->
                        <label for="price_id" class="form-label">ราคา <span style="color: red;">*</span></label>
                        <select class="form-select" id="price_id" name="price_id" required>
                            <option value="" disabled selected>-- เลือกราคา --</option>
                        </select>

                    </div>
                    <!-- Province -->
                    <label for="province_id" class="form-label">จังหวัด <span style="color: red;">*</span></label>
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
                    <label for="center_id" class="form-label">ศูนย์บริการ <span style="color: red;">*</span></label>
                    <select class="form-select" id="center_id" name="center_id" required>
                        <option value="" disabled selected>-- เลือกศูนย์บริการ --</option>
                    </select>
                    @error('center_id')
                        <small style="color:red">{{ $message }}</small>
                    @enderror


                    <!-- fttx_broadband form-->
                    <div id="fttx_broadband">
                        <label for="new" class="form-label">ประเภทลูกค้า <span style="color: red;">*</span></label>
                        <select class="form-select " id="new" name="new" required>
                            <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                            <option value="1" class=""> ลูกค้าใหม่ </option>
                            <option value="2" class=""> ลูกค้าย้ายค่าย </option>
                            <option value="0" class=""> ปรับโปรโมชั่น </option>
                        </select>
                        <label for="installation_type" class="form-label">งานติดตั้ง <span
                                style="color: red;">*</span></label>
                        <select class="form-select " id="installation_type" name="installation_type" required>
                            <option value="" disabled selected>-- เลือกวิธีการติดตั้ง --</option>
                            <option value="1" class=""> ติดตั้งเอง </option>
                            <option value="0" class=""> จ้างผู้รับเหมา </option>
                        </select>
                    </div>

                    <!-- sim_my form-->
                    <div id="sim_my">
                        <label for="cus_new" class="form-label">ประเภทลูกค้า <span style="color: red;">*</span></label>
                        <select class="form-select " id="cus_new" name="cus_new" required>
                            <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                            <option value="1" class=""> ลูกค้าใหม่ </option>
                            <option value="0" class=""> ลูกค้า(ย้ายค่าย) </option>
                        </select>
                    </div>

                    <!-- Date Form -->
                    <div id="date" class="mt-3">
                        <label for="date" class="form-label">วัน/เดือน/ปี
                            (กรอกช่องนี้เฉพาะกรณีลงข้อมูลย้อนหลัง)</label>
                        <input type="date" id="date" name="date" class="form-label" required
                            value="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- Other -->
                    <label for="other" class="form-label">หมายเหตุ</label>
                    <textarea class="form-control" id="other" name="other" rows="4">{{ old('other') }}</textarea>
                </div>
                <div class="card-footer align-items-center text-center">
                    <a href="{{ route('event_customer', $type_id) }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success" id="save-button">Save</button>

                </div>
        </form>
    </div>
    </div>
@endsection



@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("product-container");
            const incomeInput = document.getElementById("income");

            // ฟังก์ชันคำนวณรายได้รวม
            function calculateTotalIncome() {
                let totalIncome = 0;
                const productRows = document.querySelectorAll(".product-row");
                let canCalculate = true;

                // ลบข้อความแจ้งเตือนที่มีอยู่ก่อนแล้ว
                document.querySelectorAll('.product-error').forEach(el => el.remove());

                productRows.forEach(row => {
                    const productSelect = row.querySelector('[name="product_id[]"]');
                    const priceInput = row.querySelector('[name="ICTprice[]"]');
                    const quantityInput = row.querySelector('[name="quantity[]"]');

                    // ตรวจสอบว่ามีการเลือกสินค้าแล้วหรือไม่
                    if (productSelect.value === "") {
                        canCalculate = false;

                        // เพิ่มเส้นขอบสีแดงที่ช่องเลือกสินค้า
                        productSelect.classList.add('border', 'border-danger');

                        // สร้างข้อความแจ้งเตือนใต้ช่องเลือกสินค้า
                        const errorMsg = document.createElement('small');
                        errorMsg.textContent = "กรุณาเลือก Product";
                        errorMsg.classList.add('text-danger', 'product-error', 'd-block');

                        // ลบข้อความแจ้งเตือนเก่า (ถ้ามี) และเพิ่มข้อความใหม่
                        const existingError = productSelect.nextElementSibling;
                        if (existingError && existingError.classList.contains('product-error')) {
                            existingError.remove();
                        }

                        // แสดงข้อความแจ้งเตือนหลังช่องเลือกสินค้า
                        productSelect.after(errorMsg);
                        productSelect.focus();
                        return;
                    }

                    const price = parseFloat(priceInput.value) || 0;
                    const quantity = parseFloat(quantityInput.value) || 0;

                    totalIncome += price * quantity;
                });

                // อัปเดตรายได้ต่อเดือนเฉพาะเมื่อมีการเลือกสินค้าทุกแถว
                if (canCalculate && productRows.length > 0) {
                    incomeInput.value = totalIncome;
                } else {
                    incomeInput.value = "";
                }
            }

            // ตรวจจับเหตุการณ์คลิก
            document.addEventListener("click", function(event) {
                // เพิ่มแถวสินค้าใหม่
                if (event.target.classList.contains("add-product")) {
                    const newRow = event.target.closest(".product-row").cloneNode(true);

                    // รีเซ็ตค่าภายในแถวใหม่
                    newRow.querySelector("select").value = "";
                    newRow.querySelector("select").classList.remove('border', 'border-danger');
                    newRow.querySelectorAll("input").forEach(input => {
                        input.value = "";
                    });

                    // ลบข้อความแจ้งเตือนเก่า (ถ้ามี)
                    const existingError = newRow.querySelector('.product-error');
                    if (existingError) {
                        existingError.remove();
                    }
                    // เปลี่ยนปุ่ม "+" เป็นปุ่ม "-"
                    newRow.querySelector(".add-product").classList.replace("btn-success", "btn-danger");
                    newRow.querySelector(".add-product").textContent = "-";
                    newRow.querySelector(".add-product").classList.replace("add-product", "remove-product");
                    container.appendChild(newRow);
                }

                // ลบแถวสินค้า
                if (event.target.classList.contains("remove-product")) {
                    event.target.closest(".product-row").remove();
                    calculateTotalIncome();
                }
            });

            // ตรวจจับเหตุการณ์เมื่อมีการเปลี่ยนแปลงค่าในช่องอินพุต
            container.addEventListener("input", function(event) {
                if (event.target.name === "product_id[]") {
                    // ลบข้อความแจ้งเตือนเมื่อผู้ใช้เลือกสินค้า
                    const productSelect = event.target;
                    productSelect.classList.remove('border', 'border-danger');
                    const existingError = productSelect.nextElementSibling;
                    if (existingError && existingError.classList.contains('product-error')) {
                        existingError.remove();
                    }
                }
                // เมื่อมีการเปลี่ยนแปลงข้อมูลสินค้า จำนวน หรือราคา ให้คำนวณใหม่
                if (event.target.name === "product_id[]" ||
                    event.target.name === "ICTprice[]" ||
                    event.target.name === "quantity[]") {
                    calculateTotalIncome();
                }
            });
        });
    </script>

    <script>
        $('#service_id').change(function() {
            var serviceId = $(this).val();

            $.ajax({
                url: '/getIct_service',
                type: 'GET',
                data: {
                    service_id: serviceId
                },
                success: function(data) {

                    $('#ict_service').empty();
                    $('#ict_service').append(
                        '<option value="" disabled selected>-- เลือก ICT Solution --</option>');


                    $.each(data, function(index, ict_service) {
                        $('#ict_service').append('<option value="' + ict_service
                            .ict_service_id + '">' +
                            ict_service.service_name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log("เกิดข้อผิดพลาด:", error); // แสดง error ถ้ามี
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูลบริการ');
                }
            });
        });
    </script>

    <script>
        $('#ict_service').change(function() {
            var ICTserviceId = $(this).val();

            $.ajax({
                url: '/getProduct',
                type: 'GET',
                data: {
                    ict_service_id: ICTserviceId
                },


                success: function(data) {
                    $('#product_id').empty();
                    $('#product_id').append(
                        '<option value="" disabled selected>-- เลือกProduct --</option>'
                    );

                    // เพิ่ม options สำหรับบริการ
                    $.each(data, function(index, products) {
                        $('#product_id').append('<option value="' + products.product_id + '">' +
                            products.product_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Error fetching services');
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูลบริการ');
                }
            });
        });
    </script>
    <script>
        document.getElementById("date").valueAsDate = new Date();
    </script>

    <script>
        $(document).ready(function() {
            // ฟังก์ชันเพื่อดึงข้อมูลบริการจาก type_id
            function loadServices(typeId) {
                $.ajax({
                    url: '/getService', // URL สำหรับดึงข้อมูลบริการ
                    type: 'GET',
                    data: {
                        type_id: typeId
                    },
                    success: function(data) {
                        $('#service_id').empty(); // เคลียร์ตัวเลือกเก่าใน #service_id
                        $('#service_id').append(
                            '<option value="" disabled selected>-- เลือกบริการ --</option>');

                        // แยกบริการที่มีคำว่า "ร่วม" ออกมา
                        var servicesWithR = data.filter(function(service) {
                            return service.service_name.includes('ร่วม');
                        });

                        var servicesWithoutR = data.filter(function(service) {
                            return !service.service_name.includes('ร่วม');
                        });

                        // รวมบริการที่มีคำว่า "ร่วม" ขึ้นมาก่อน
                        var allServices = servicesWithR.concat(servicesWithoutR);

                        // เพิ่ม options สำหรับบริการ
                        $.each(allServices, function(index, service) {
                            $('#service_id').append('<option value="' + service.service_id +
                                '">' +
                                service.service_name + '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error fetching services');
                        alert('เกิดข้อผิดพลาดในการดึงข้อมูลบริการ');
                    }
                });
            }

            // ดึงค่า type_id จาก select เมื่อโหลดหน้า
            var currentTypeId = $('#type_id').val(); // ค่า type_id ปัจจุบัน
            if (currentTypeId) {
                loadServices(currentTypeId); // เรียกใช้ฟังก์ชันเพื่อดึงบริการ
            }

            // เมื่อมีการเปลี่ยนแปลงค่าใน #type_id
            $('#type_id').change(function() {
                var typeId = $(this).val(); // ดึงค่า type_id ที่เลือก
                loadServices(typeId); // ดึงข้อมูลบริการใหม่
            });
        });



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
                    errorMessage.textContent = "กรุณาเลือกไฟล์ที่เป็น รูปภาพ หรือ PDF เท่านั้น";
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
                if (serviceName.toLowerCase().includes('fttx')) {
                    $('#fttx_broadband,#groupNet, #groupNet1').show();
                    $('#sim_my, #ict_solution, #ict_solution1').hide();

                    // เปิด required สำหรับฟอร์ม fttx_broadband
                    $('#new, #installation_type').prop('required', true);
                    // กลับ label เป็น "ชื่อ นามสกุล"
                    $('#fullname_label').text('ชื่อ นามสกุล');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#cus_new, #income, #customer_type, #quote, #product_id, #quantity_id ').prop('required',
                        false);
                    $('#save-button').prop('disabled', false);


                } else if (serviceName.toLowerCase().includes('sim')) {
                    $('#sim_my,#groupNet, #groupNet1').show();
                    $('#fttx_broadband, #ict_solution, #ict_solution1').hide();

                    // เปิด required สำหรับฟอร์ม sim_my
                    $('#cus_new').prop('required', true);

                    // กลับ label เป็น "ชื่อ นามสกุล"
                    $('#fullname_label').text('ชื่อ นามสกุล');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#new, #installation_type, #income, #customer_type, #quote, #product_id, #quantity_id').prop(
                        'required', false);
                    $('#save-button').prop('disabled', false);

                } else if (serviceName.toLowerCase().includes('ict')) {
                    $('#ict_solution, #ict_solution1').show();
                    $('#fttx_broadband, #sim_my, #groupNet, #groupNet1').hide();

                    // เปิด required สำหรับฟิลด์ income
                    $('#income, #customer_type, #product_id, #quantity_id').prop('required', true);
                    // เปลี่ยน label เป็น "ชื่อ/ชื่อหน่วยงาน"
                    $('#fullname_label').text('ชื่อ/ชื่อหน่วยงาน');

                    // ปิด required สำหรับฟอร์มอื่น ๆ
                    $('#new, #installation_type, #cus_new, #promotion_id, #speed_id, #price_id, #id_card, #cus_photo')
                        .prop('required',
                            false);
                    $('#save-button').prop('disabled', false);
                } else {
                    // ซ่อนฟอร์มทั้งหมด
                    $('#fttx_broadband, #sim_my, #ict_solution, #ict_solution1').hide();

                    // ปิด required สำหรับทุกฟอร์ม
                    $('#new, #installation_type, #cus_new, #income, #customer_type, #quote , #product_id, #quantity_id')
                        .prop('required', false);

                    $('#save-button').prop('disabled', true);

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

    {{-- <script>
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
    </script> --}}

    <script>
        $(document).ready(function() {
            // เมื่อมีการพิมพ์ในช่อง cus_fullname
            $('#cus_fullname').on('input', function() {
                var selectedService = $('#service_id').val(); // ดึงค่าของ service_id
                if (!selectedService) { // ถ้ายังไม่ได้เลือกบริการ
                    $('#service-alert').show(); // แสดงข้อความแจ้งเตือน
                    $(this).val(''); // ลบค่าที่พิมพ์ไป
                } else {
                    $('#service-alert').hide(); // ซ่อนข้อความแจ้งเตือนถ้าเลือกบริการแล้ว
                }
            });

            // เมื่อมีการเปลี่ยนค่าใน select (service_id)
            $('#service_id').on('change', function() {
                $('#service-alert').hide(); // ซ่อนข้อความแจ้งเตือนเมื่อเลือกบริการ
            });
        });
    </script>
@endsection
