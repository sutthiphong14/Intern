@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">





        <form action="{{ route('customer_update', $customer->cus_id) }}" method="POST" enctype="multipart/form-data"
            id="formID">
            @csrf
            @method('PUT') <!-- Method for updating data -->
            @php
                // จัดเรียงรายการให้ 'ร่วม' ขึ้นก่อน
                $sortedServices = $services->sortByDesc(
                    fn($service) => strpos($service->service_name, 'ร่วม') !== false,
                );
            @endphp
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>แก้ไขข้อมูลลูกค้า</h2>
            </div>

            <div class="mb-3">
                <!-- Dropdown for Type -->
                <label for="type_id" class="form-label">กิจกรรม</label>
<select class="form-select" id="type_id" name="type_id" >
    @foreach ($types as $type)
        @if ($type->type_id == $customer->type_id)
            <option value="{{ $type->type_id }}" selected>
                {{ $type->type_name }}
            </option>
        @endif
    @endforeach
</select>

                


                <label for="service_id" class="form-label">บริการ</label>
                <select class="form-select bg-success" id="service_id" name="service_id" required >
                    <option value="" disabled>-- เลือกบริการ --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->service_id }}"
                            {{ $customer->service_id == $service->service_id ? 'selected' : '' }}>
                            {{ $service->service_name }}
                        </option>
                    @endforeach
                </select>
                <!-- เพิ่มข้อความคำแนะนำ หรือข้อผิดพลาดได้ -->
                @error('service_id')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror


                <label for="cus_fullname" class="form-label" id="fullname_label">ชื่อ นามสกุล</label>
                <input type="text" class="form-control" id="cus_fullname" name="cus_fullname"
                    value="{{ $customer->cus_fullname }}" required>

                <div id="groupNet1">
                    <!-- ID Card -->
                    <label for="id_card" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                    <input type="text" class="form-control" id="id_card" name="id_card"
                        value="{{ $customer->id_card }}" oninput="validateIdCard()" required>
                    <p id="error-id_card" style="color:red"></p>


                    <div>
                        <img src="{{ $customer->cus_photo ? asset('storage/' . $customer->cus_photo) : 'path_to_default_image.jpg' }}"
                            alt="Current Image" width="150">
                    </div>
                    <label for="cus_photo" class="form-label">รูปภาพ</label>
                    <input type="file" class="form-control" id="cus_photo" name="cus_photo"
                        value="{{ $customer->cus_photo }}">
                    <p id="error-cus_photo" style="color:red"></p>

                </div>

                <div id="ict_solution1">
                    <label for="customer_type" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-control" id="customer_type" name="customer_type" required>
                        <option value="" disabled selected>-- เลือกหน่วยงาน --</option>
                        <option value="หน่วยงานรัฐบาล"
                            {{ old('customer_type', $ict_solution->customer_type ?? '') == 'หน่วยงานรัฐบาล' ? 'selected' : '' }}>
                            หน่วยงานรัฐบาล</option>
                        <option value="หน่วยงานเอกชน"
                            {{ old('customer_type', $ict_solution->customer_type ?? '') == 'หน่วยงานเอกชน' ? 'selected' : '' }}>
                            หน่วยงานเอกชน</option>
                        <option value="หน่วยงานทั่วไป"
                            {{ old('customer_type', $ict_solution->customer_type ?? '') == 'หน่วยงานทั่วไป' ? 'selected' : '' }}>
                            หน่วยงานทั่วไป</option>

                    </select>
                    </select>

                    @if ($ict_solution->quote ?? '')
                        <div class="mt-3">
                            <p><strong>มีการแนบไฟล์ใบเสนอราคาอยู่แล้ว:</strong> <a
                                    href="{{ asset('storage/' . $ict_solution->quote) }}" target="_blank"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-file-earmark-pdf"></i> ดูไฟล์
                                </a></p>

                        </div>
                    @endif

                    <!-- Photo -->
                    <label for="quote" class="form-label">ใบเสนอราคา (รูปภาพ/pdf.)</label>
                    <input type="file" class="form-control" id="quote" name="quote">

                    <p id="file-error" style="color:red; display:none;">กรุณาเลือกไฟล์ที่ถูกต้อง (รูปภาพหรือ PDF)</p>
                </div>

                <label for="cus_address" class="form-label">ที่อยู่</label>
                <textarea class="form-control" id="cus_address" name="cus_address" rows="4" required>{{ $customer->cus_address }}</textarea>


                <div id="groupNet">
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
                                {{ $customer->prices_id == $prices->price_id ? 'selected' : '' }}>
                                {{ $prices->price_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

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

                {{-- ict_solution --}}
                <div id="ict_solution">
                    <div id="product-container">
                        @if ($productsWithQuantity->isNotEmpty())
                            {{-- กรณีมี Product อยู่แล้ว --}}
                            @foreach ($productsWithQuantity as $productData)
                                <div class="d-flex product-row">
                                    <div>
                                        <label for="product_id" class="form-label">Product</label>
                                        <select class="form-select" id="product_id" name="product_id[]" required>
                                            <option value="" disabled>-- เลือก Product --</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_id }}"
                                                    {{ $productData->product_id == $product->product_id ? 'selected' : '' }}>
                                                    {{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="quantity" class="form-label">จำนวน</label>
                                        <input type="number" name="quantity[]" class="form-control"
                                            placeholder="ระบุจำนวน" required value="{{ $productData->pivot->quantity }}">
                                    </div>
                                    <button type="button" class="btn btn-success add-product mt-4">+</button>
                                    <button type="button" class="btn btn-danger remove-product mt-4">-</button>
                                </div>
                            @endforeach
                        @else
                            {{-- ถ้าไม่มีข้อมูลให้แสดงฟอร์มเปล่า --}}
                            <div class="d-flex product-row">
                                <div>
                                    <label for="product_id" class="form-label">Product</label>
                                    <select class="form-select" id="product_id" name="product_id[]">
                                        <option value="" disabled selected>-- เลือก Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="quantity" class="form-label">จำนวน</label>
                                    <input type="number" name="quantity[]" class="form-control" id="quantity"
                                        placeholder="ระบุจำนวน">
                                </div>
                                <button type="button" class="btn btn-success add-product mt-4">+</button>
                                <button type="button" class="btn btn-danger remove-product mt-4">-</button>
                            </div>
                        @endif
                    </div>

                    <label for="income" class="form-label">รายได้ต่อเดือน</label>
                    <input type="number" id="income" name='income' class="form-control bg-warning" required
                        value="{{ old('income', $ict_solution->income ?? '') }}">
                </div>




                <!-- fttx_broadband form -->
                <div id="fttx_broadband">
                    <label for="new" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="new" name="new" required>
                        <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                        <option value="1" class="bg-secondary"
                            {{ isset($fttxBroadband) && $fttxBroadband->new == 1 ? 'selected' : '' }}>
                            ลูกค้าใหม่</option>
                        <option value="0" class="bg-secondary"
                            {{ isset($fttxBroadband) && $fttxBroadband->new == 0 ? 'selected' : '' }}>
                            ปรับโปรโมชั่น</option>
                    </select>

                    <label for="installation_type" class="form-label">งานติดตั้ง</label>
                    <select class="form-select bg-warning" id="installation_type" name="installation_type" required>
                        <option value="" disabled selected>--
                            เลือกวิธีการติดตั้ง --</option>
                        <option value="1" class="bg-secondary"
                            {{ isset($fttxBroadband) && $fttxBroadband->installation_type == 1 ? 'selected' : '' }}>
                            ติดตั้งเอง</option>
                        <option value="0" class="bg-secondary"
                            {{ isset($fttxBroadband) && $fttxBroadband->installation_type == 0 ? 'selected' : '' }}>
                            จ้างผู้รับเหมา</option>
                    </select>
                </div>

                <!-- sim_my form -->
                <div id="sim_my">
                    <label for="cus_new" class="form-label">ประเภทลูกค้า</label>
                    <select class="form-select bg-warning" id="cus_new" name="cus_new" required>
                        <option value="" disabled selected>-- เลือกประเภทลูกค้า --</option>
                        <option value="1" class="bg-secondary"
                            {{ isset($sim_my) && $sim_my->cus_new == 1 ? 'selected' : '' }}>
                            ลูกค้าใหม่ </option>
                        <option value="0" class="bg-secondary"
                            {{ isset($sim_my) && $sim_my->cus_new == 0 ? 'selected' : '' }}>
                            ลูกค้า(ย้ายค่าย) </option>
                    </select>
                </div>
                <!-- Date Form -->
                <div id="date" class="mt-3">
                    <label for="date" class="form-label">วัน/เดือน/ปี</label>
                    <input type="date" id="date" name="date" class="form-label" required
                        value="{{ $customer->created_at->format('Y-m-d') }}">
                </div>


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
    
</script>
    <script>
        $(document).ready(function() {
            // กำหนดค่าเริ่มต้นเมื่อโหลดหน้า
            var serviceId = $('#service_id').val();
            // สมมติว่ามีตัวแปรที่เก็บค่า product_id ที่เลือกไว้ก่อนหน้า
            var selectedProductId = "{{ $customer->product_id ?? '' }}"; // ปรับตามโครงสร้างข้อมูลของคุณ

            if (serviceId) {
                loadProducts(serviceId, selectedProductId);
            }

            // เมื่อเปลี่ยนค่า service_id
            $('#service_id').change(function() {
                var serviceId = $(this).val();
                loadProducts(serviceId, selectedProductId);
            });

            function loadProducts(serviceId, selectedProductId) {
                $.ajax({
                    url: '/getProduct',
                    type: 'GET',
                    data: {
                        service_id: serviceId
                    },
                    success: function(data) {
                        $('#product_id').empty();
                        $('#product_id').append(
                            '<option value="" disabled>-- เลือก Product --</option>'
                        );

                        // เพิ่ม options สำหรับ product
                        $.each(data, function(index, product) {
                            // ตรวจสอบว่าเป็น product ที่เคยเลือกไว้หรือไม่
                            var selected = (product.product_id == selectedProductId) ?
                                'selected' : '';

                            $('#product_id').append('<option value="' + product.product_id +
                                '" ' + selected + '>' +
                                product.product_name + '</option>');
                        });

                        // ถ้าไม่มีข้อมูลที่เลือกไว้ก่อนหน้า ให้เลือกตัวแรก
                        if (data.length > 0 && !selectedProductId) {
                            // เลือกตัวแรกเป็นค่าเริ่มต้น (ถ้าต้องการ)
                            // $('#product_id').val(data[0].product_id);
                        }
                    },
                    error: function() {
                        console.log('Error fetching products');
                        alert('เกิดข้อผิดพลาดในการดึงข้อมูล Product');
                    }
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // ดึงค่า type_id ปัจจุบัน
            var typeId = $('#type_id').val();
            var currentServiceId = "{{ $customer->service_id }}"; // ดึงค่า service_id ที่บันทึกไว้

            // เรียกใช้ AJAX ทันที
            loadServices(typeId, currentServiceId);

            // Event listener สำหรับการเปลี่ยนค่า type_id
            $('#type_id').change(function() {
                var typeId = $(this).val();

                loadServices(typeId, currentServiceId);
                // ✅ รีเซ็ตค่า service_id และเคลียร์ตัวเลือก
                $('#service_id').empty().append(
                    '<option value="" disabled selected>-- เลือกบริการ --</option>');
                // ✅ รีเซ็ตค่า quantity (ทุก input ที่มี name="quantity[]")
                $('input[name="quantity[]"]').val('');

            });

            // แยกโค้ด AJAX เป็นฟังก์ชันเพื่อลดการเขียนซ้ำ
            function loadServices(typeId, currentServiceId) {
                $.ajax({
                    url: '/getService',
                    type: 'GET',
                    data: {
                        type_id: typeId
                    },
                    success: function(data) {
                        $('#service_id').empty();


                        // วนลูปเพิ่มข้อมูลจากฐานข้อมูล
                        $.each(data, function(index, service) {
                            var selectedAttr = (service.service_id == currentServiceId) ?
                                'selected' : '';
                            $('#service_id').append('<option value="' + service.service_id +
                                '" ' + selectedAttr + '>' +
                                service.service_name + '</option>');
                        });
                    },
                    error: function() {
                        console.log('Error fetching services');
                        alert('เกิดข้อผิดพลาดในการดึงข้อมูลบริการ');
                    }
                });
            }

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
                } else if (serviceName.toLowerCase().includes('ict')) {
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





            // ✅ เช็คค่า `service_name` ทันทีที่โหลดหน้า
            var selectedService = $('#service_id').val(); // ได้ค่า service_id ที่ถูกเลือก
            if (selectedService) {
                var serviceName = $('#service_id option:selected').text();
                toggleForms(serviceName);
            }

            // ✅ เช็คค่าใหม่เมื่อเปลี่ยน `service_id`
            $('#service_id').change(function() {
                var serviceName = $(this).find('option:selected').text();
                toggleForms(serviceName);
                console.log(serviceName)
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
                    newRow.querySelector(".add-product").textContent = "+";
                    container.appendChild(newRow);
                }

                if (event.target.classList.contains("remove-product")) {
                    event.target.closest(".product-row").remove();
                }
            });
        });
    </script>
@endsection
