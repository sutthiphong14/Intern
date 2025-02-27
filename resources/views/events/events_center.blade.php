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
        <a href="javascript:history.back(-2)" class="">
        จัดการกิจกรรม {{ $types->type_name }}
        </a>
        /
        <a href="javascript:history.back()" class="">
        ศูยน์บริการ
        </a>
        /
    </span> จังหวัด {{ $provinces->province_name }}
</h4>

<div class="content-wrapper mb-5">
<div class="card ">
        <div class="d-flex">
        <div class="d-flex justify-content-between align-items-center gap-2">
                <h3 class="card-header text-dark">สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }} จังหวัด{{ $provinces->province_name }}</h3>
                <div class="d-flex align-items-center gap-2">
                </div>
            </div>
        </div>
        <div class="card-body ">
        <div class="table-responsive ">
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ศูยน์บริกาาร</th>
                    <th colspan="4">FTTX</th>
                    <th colspan="4">SIM my</th>
                    <th colspan="2">Ict Solution</th>

                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="4">new</th>
                    <th rowspan="4">ติดตั้งเอง</th>
                    <th rowspan="4">จ้างผู้รับเหมา</th>
                    <th rowspan="4">ปรับโปรโมชั่น</th>

                </tr>
                <tr class="bg-dark text-center">
                    <th rowspan="2">ลูกค้าใหม่</th>
                    <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
                    <th colspan="2">เติมเงินรายปี</th>
                    <th rowspan="2">จำนวน
                        (ราย)</th>
                    <th rowspan="2">รายได้</th>

                </tr>
                <tr class="bg-dark text-center ">
                    <th>จำนวน
                        (ราย)</th>
                    <th>ยอดเงิน</th>
                </tr>


            </thead>
            <tbody class="text-center">
                @foreach ($centers as $center)
                    {{-- Province ID <= 33 --}}
                    <tr>

                        <td>{{ $center->center_name }}</td>
                        <td>{{ $fttxNew[$center->center_id] ?? 0 }}</td>
                        <td>{{ $selfInstall[$center->center_id] ?? 0 }}</td>
                        <td>{{ $HireInstall[$center->center_id] ?? 0 }}</td>
                        <td>{{ $adjust[$center->center_id] ?? 0 }}</td>

                        <td>{{ $Simmy_new[$center->center_id] ?? 0 }}</td>
                        <td>{{ $Simmy_move[$center->center_id] ?? 0 }}</td>
                        <td>{{ $Simmy_count[$center->center_id] ?? 0 }}</td>
                        <td>{{ $Simmy_price[$center->center_id] ?? 0 }}</td>
                        <td>
                            @if (isset($Ict_count[$center->center_id]) && $Ict_count[$center->center_id] > 0)
                                <a href="#" class="text-info" id="view"
                                    data-center-id="{{ $center->center_id }}" data-type-id="{{ $types->type_id }}">
                                    {{ $Ict_count[$center->center_id] }}
                                </a>
                            @else
                                {{ $Ict_count[$center->center_id] ?? 0 }}
                            @endif
                        </td>



                        <td>{{ $Ict_income[$center->center_id] ?? 0 }}</td>


                    </tr>
                   
                @endforeach
                <tr class="bg-dark">

                    <td colspan="1">รวม</td>
                    <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
                    <td>{{ $sumAdjust + $sumAdjustOver33 }}</td>
                    <td>{{ $sumNew + $sumNewOver33 }}</td>
                    <td>{{ $sumMove + $sumMoveOver33 }}</td>
                    <td>{{ $sumCount + $sumCountOver33 }}</td>
                    <td>{{ $sumPrice + $sumPriceOver33 }}</td>
                    <td>{{ $IctCount + $IctCountOver33 }}</td>
                    <td>{{ $IctIncome + $IctIncomeOver33 }}</td>
                </tr>
            </tbody>



        </table>
        </div>
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center" id="exampleModalLabel">ข้อมูลสินค้า</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <div id='btn-detail' class="text-end mb-2"> </div>
                            <thead>
                                <tr class="bg-dark text-center">
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวน</th>
                                </tr>
                            </thead>
                            <tbody id="productDetails" class="text-center">
                                <!-- รายละเอียดสินค้า -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#view', function(e) {
            e.preventDefault(); // ป้องกันการทำงานของ link

            var centerId = $(this).data('center-id'); // รับค่า center_id
            var typeId = $(this).data('type-id'); // รับค่า type_id ที่ต้องการ

            // ส่งคำขอไปยัง route ที่กำหนด
            $.ajax({
                url: "{{ route('getproduct_center', ['center_id' => '__centerId__', 'type_id' => '__typeId__']) }}"
                    .replace('__centerId__', centerId).replace('__typeId__', typeId),
                method: "GET",
                success: function(response) {
                    // ถ้าได้รับข้อมูลสำเร็จ
                    var productDetails = $('#productDetails');
                    var btn_detail = $('#btn-detail');
                    productDetails.empty(); // ลบข้อมูลเก่าก่อน
                    btn_detail.empty();

                    // แสดงชื่อศูนย์บริการใน Modal
                    $('#exampleModalLabel').text('ข้อมูลProducts - ' + response.center_name);

                    // เช็คว่ามีข้อมูลหรือไม่
                    if (response.products.length === 0) {
                        productDetails.append('<tr><td colspan="3">ไม่มีข้อมูลสินค้า</td></tr>');
                    } else {
                        // เก็บค่าของ center_id ทั้งหมด
                        var allCenterIds = [];

                        // วนลูปแสดงข้อมูลสินค้าทั้งหมด
                        response.products.forEach(function(product) {
                            console.log(product.center_id); // แสดง center_id ของแต่ละสินค้า
                            allCenterIds.push(product.center_id); // เก็บค่า center_id
                        });

                        // กรองค่าซ้ำด้วย Set
                        var uniqueCenterIds = [...new Set(allCenterIds)];

                        // สร้างลิงก์สำหรับทุก center_id ที่ไม่ซ้ำ
                        var detailUrl = "{{ route('detail_cus', ['center_id' => '__centerIds__']) }}"
                            .replace('__centerIds__', uniqueCenterIds.join(','));

                        // สร้างปุ่มเดียว
                        btn_detail.append(
                            '<a href="' + detailUrl +
                            '" class="btn-sm btn-primary">ดูรายละเอียดลูกค้าทั้งหมด</a>'
                        );
                    }




                    // เช็คและแสดง product_counts (จำนวนสินค้าทั้งหมด)
                    if (response.product_counts && Object.keys(response.product_counts).length > 0) {

                        for (const [productName, count] of Object.entries(response.product_counts)) {

                            productDetails.append(
                                '<tr>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + count + '</td>' +
                                '</tr>'
                            );
                        }

                    }

                    // ✅ แสดง product_counts แยกต่างหาก
                    console.log("Product Counts:", );

                    // เปิด modal
                    $('#productModal').modal('show');
                },
                error: function() {
                    alert('ไม่สามารถดึงข้อมูลได้');
                }
            });
        });
    </script>
@endsection
