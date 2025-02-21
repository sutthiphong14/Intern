@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>รายละเอียดลูกค้า 
            {{ $data->first()->province->province_name }}/
            {{ $data->first()->center->center_name }}
        </h2>
        <table class="table table-bordered">
            <thead id="table-heard">
                <tr class="bg-dark text-light">

            </thead>
            <tbody id="customerTable">

            </tbody>
        </table>


        <!-- Modal view -->
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

                            <p><span class="fw-bold text-dark">ชื่อ-นามสกุล:</span> {{ $customer->cus_fullname }}</p>
                            @if (strpos(strtolower($customer->service->service_name), 'fttx_broadband') !== false ||
                                    strpos(strtolower($customer->service->service_name), 'sim my') !== false)
                                <p><span class="fw-bold text-dark">รหัสบัตรประชาชน:</span> {{ $customer->id_card }}</p>
                            @else
                                <p><span class="fw-bold text-dark">ประเภทลูกค้า:</span>
                                    {{ $dataIct->where('cus_id', $customer->cus_id)->first()->customer_type }}</p>
                            @endif
                            <p><span class="fw-bold text-dark">ที่อยู่:</span> {{ $customer->cus_address }}</p>
                            <p><span class="fw-bold text-dark">กิจกรรม:</span>
                                {{ $customer->type->type_name ?? 'ไม่ระบุ' }}
                            </p>
                            <p><span class="fw-bold text-dark">บริการ:</span>
                                {{ $customer->service->service_name ?? 'ไม่ระบุ' }}
                                <a class="btn btn-warning btn-sm text-dark" data-bs-toggle="tooltip"
                                    data-bs-placement="right" data-bs-html="true"
                                    data-bs-original-title="
                                  <div class='text-start py-3' style='padding: 10px; background-color: #f9f9f9; border-radius: 5px;'>
                                      <strong>ข้อมูลบริการของลูกค้า</strong><br>
                                      <span>----------------------------</span>
                                      <strong class='text-warning'>บริการ:   </strong> {{ $customer->service->service_name }}<br>
                                      @php
                                          $fttxData = \App\Models\Fttxbroadband::where(
                                              'cus_id',
                                              $customer->cus_id,
                                          )->first();
                                          $simmyData = \App\Models\Simmy::where('cus_id', $customer->cus_id)->first();
                                          $ictData = \App\Models\IctSolution::where(
                                              'cus_id',
                                              $customer->cus_id,
                                          )->first();

                                      @endphp
                              @if ($fttxData && str_contains(strtolower($customer->service->service_name), 'fttx_broadband'))
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : 'ปรับโปรโมชั่น' }}<br>
                                          <strong class='text-warning'>งานติดตั้ง:   </strong> {{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}
@elseif ($simmyData && str_contains(strtolower($customer->service->service_name), 'sim my'))
<strong class='text-warning'>ประเภทลูกค้า:   </strong> {{ $simmyData->cus_new == 1 ? 'ลูกค้าใหม่' : 'ลูกค้า(ย้ายค่าย)' }}<br>
@elseif ($ictData && str_contains(strtolower($customer->service->service_name), 'ict solution'))
<strong class='text-warning'>รายได้ต่อเดือน:   </strong> {{ $ictData->income }}
                                                  
                                                
<br>
@else
<strong class='text-warning'>ประเภทลูกค้า:   </strong> ไม่ระบุ<br>
                                                          <strong class='text-warning'>ข้อมูลเพิ่มเติม:   </strong> ไม่ระบุ
@endif
                                          </div>
                                          ">
                                    รายละเอียด
                                </a>
                            </p>
                            @if (strpos(strtolower($customer->service->service_name), 'fttx_broadband') !== false ||
                                    strpos(strtolower($customer->service->service_name), 'sim my') !== false)
                                <p><span class="fw-bold text-dark">โปรโมชั่น:</span>
                                    {{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</p>
                                <p><span class="fw-bold text-dark">ความเร็ว:</span>
                                    {{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</p>
                                <p><span class="fw-bold text-dark">ราคา:</span>
                                    {{ $customer->price->price_name ?? 'ไม่ระบุ' }}
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
                            @endif

                            @if (strpos(strtolower($customer->service->service_name), 'ict') !== false)
                                <p><span class="fw-bold text-dark">จังหวัด:</span>
                                    {{ $customer->province->province_name }}
                                </p>
                                <p><span class="fw-bold text-dark">ศูนย์บริการ:</span>
                                    {{ $customer->center->center_name }}
                                </p>

                                @if ($dataIct->isNotEmpty() && $dataIct->where('cus_id', $customer->cus_id)->first()->quote)
                                    @php
                                        $quotePath = asset(
                                            'storage/' . $dataIct->where('cus_id', $customer->cus_id)->first()->quote,
                                        );
                                        $fileExtension = pathinfo(
                                            $dataIct->where('cus_id', $customer->cus_id)->first()->quote,
                                            PATHINFO_EXTENSION,
                                        );
                                    @endphp

                                    <div class="d-flex">
                                        <p><span class="fw-bold text-dark">ใบเสนอราคา:</span></p>

                                        @if (in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']))
                                            <!-- แสดงรูปภาพ -->
                                            <br>
                                            <img src="{{ $quotePath }}" alt="Customer Quote"
                                                style="width: 100%; max-width: 100px;" class="mt-3">
                                        @elseif (strtolower($fileExtension) === 'pdf')
                                            <!-- แสดงลิงก์สำหรับไฟล์ PDF -->
                                            <p>
                                                <a href="{{ $quotePath }}" target="_blank">
                                                    <span class="btn-sm btn-info">คลิกเพื่อดู</span>
                                                </a>
                                            </p>
                                        @endif

                                        <!-- ปุ่มดาวน์โหลด -->

                                        <a href="{{ $quotePath }}" class="btn btn-success mb-3 btn-sm " download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <p><strong>ใบเสนอราคา:</strong> ไม่มีใบเสนอราคา</p>
                                @endif
                                <p><span class="fw-bold text-dark">หมายเหตุ</span> {{ $customer->other ?? 'ไม่ระบุ' }}</p>



                                <p><span class="fw-bold text-dark">ข้อมูลสินค้า</span></p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center  bg-dark">
                                            <th>ชื่อสินค้า</th>
                                            <th>จำนวน</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($dataIct->where('cus_id', $customer->cus_id)->isNotEmpty())
                                            @foreach ($dataIct->where('cus_id', $customer->cus_id)->first()->products as $product)
                                                <tr class="text-center">
                                                    <td>{{ $product->product_name ?? 'ไม่มีสินค้า' }}</td>
                                                    <td>{{ $product->pivot->quantity ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2">ไม่มีข้อมูลสินค้า</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
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
    <script>
        let customerTable = document.getElementById('customerTable');
        let customerTableH = document.getElementById('table-heard');
        customerTable.innerHTML = ''; // ลบข้อมูลเดิมในตาราง
        customerTableH.innerHTML = '';
        let dataIct = @json($dataIct); // ข้อมูล IctSolution
        let data = @json($data); // ข้อมูลลูกค้า
        // จับคู่ข้อมูลจาก data และ dataIct

        data.forEach((customer, index) => {
            let customerTableH = document.getElementById('table-heard');
            let ictData = dataIct.find(ict => ict.cus_id === customer.cus_id);

            customerTableH.innerHTML = `
                             <tr class="bg-dark text-light">
                              <th>#</th>
                                 <th>ชื่อ-นามสกุล</th>
                                <th>ประเภทลูกค้า</th>
                                <th>รายได้</th>
                                 <th>เครื่องมือ</th>
                                 </tr>
                                    `;
            // ค้นหาข้อมูล ICT ที่ตรงกับ customer

            customerTable.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${customer.cus_fullname}</td>
                                      <td>${ictData ? ictData.customer_type : 'N/A'}</td> <!-- แสดงประเภทจาก ict -->
                <td>${ictData ? ictData.income : 'N/A'}</td> <!-- แสดงรายได้จาก ict -->
                                    <td>
                                       
                                           
                                                
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#customerModal${customer.cus_id}">
                                                    View
                                                </button>
                                           
                                        
                                    </td>
                                </tr>
                            `;
        });
    </script>
@endsection
