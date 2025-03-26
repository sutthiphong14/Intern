<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลลูกค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .table-header {
            background-color: #343a40;
            color: white;
        }

        .bg-light-blue {
            background-color: #e6f2ff;
        }

        .bg-light-green {
            background-color: #e6ffe6;
        }

        .bg-light-orange {
            background-color: #fff2e6;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-4">
        <h3 class="mb-3">ข้อมูลลูกค้า กิจกรรม {{ $activityName }} จังหวัด {{ $provinceName }}</h3>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr class="table-header text-center align-middle">
                                <th rowspan="2">ประเภทบริการ</th>
                                <th rowspan="2">ชื่อ-นามสกุล</th>
                                <th rowspan="2">หมายเลขโทรศัพท์</th>
                                <th rowspan="2">เลขบัตรประชาชน</th>
                                <th rowspan="2">ที่อยู่</th>
                                <th rowspan="2">ศูนย์บริการ/จังหวัด</th>
                                <th rowspan="2">ประเภทลูกค้า</th>
                                <th colspan="5">รายละเอียดบริการ</th>
                                <th colspan="5">รายละเอียดสินค้า (ICT)</th>

                                <th rowspan="2">ยอดเงิน</th>

                            </tr>
                            <tr class="table-header text-center">
                                <th>งานติดตั้ง</th>
                                <th>โปรโมชั่น</th>
                                <th>ความเร็ว</th>
                                <th>ราคา</th>
                                <th>หมายเหตุ</th>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>ราคา/หน่วย</th>
                                <th>ราคารวม</th>
                                <th>รายได้/เดือน</th>
                            </tr>
                        </thead>
                        <tbody id="customerTable">
                            @php
                            // จัดกลุ่มข้อมูลตามประเภทบริการ
                            $customersGrouped = $data->groupBy(function ($customer) {
                                return $customer->service->service_name ?? 'ไม่ระบุ';
                            });
                            
                            $bgColorClasses = [
                                'ICT solution' => 'bg-light-blue',
                                'FTTX Broadband' => 'bg-light-green',
                                'SIM my(เติมเงิน)' => 'bg-light-orange',
                                'TopUp' => 'bg-light-yellow',
                            ];
                            @endphp
                            
                            @if ($data->count() > 0)
                                @foreach ($customersGrouped as $serviceName => $customers)
                                    @php
                                        $bgColorClass = $bgColorClasses[$serviceName] ?? '';
                                    @endphp
                            
                                    @foreach ($customers as $index => $customer)
                                        @php
                                            $isFttx = strpos(strtolower($serviceName), 'fttx') !== false;
                                            $isSim = strpos(strtolower($serviceName), 'sim') !== false;
                                            $isIct = strpos(strtolower($serviceName), 'ict') !== false;
                            
                                            // ดึงข้อมูลเพิ่มเติมตามประเภทบริการ
                                            $fttxData = $isFttx
                                                ? \App\Models\Fttxbroadband::where('cus_id', $customer->cus_id)->first()
                                                : null;
                                            $simmyData = $isSim
                                                ? \App\Models\Simmy::where('cus_id', $customer->cus_id)->first()
                                                : null;
                                            $ictData = $isIct
                                                ? \App\Models\IctSolution::where('cus_id', $customer->cus_id)->first()
                                                : null;
                            
                                            // สำหรับ ICT ต้องดึงข้อมูลสินค้า
                                            $ictProducts = $isIct && $ictData ? $ictData->products : collect();
                                            
                                            $displayedCustomers = [];
                                        @endphp
                                        
                                        @if ($isIct && $ictProducts->isNotEmpty())
                                            @php
                                                $firstProduct = true;
                                                $currentCustomer = null;
                                            @endphp
                                            
                                            @foreach ($ictProducts as $productIndex => $product)
                                                @php
                                                    // ตรวจสอบว่าเป็นลูกค้าคนใหม่หรือไม่
                                                    $isNewCustomer = $currentCustomer !== $customer->cus_fullname;
                                                    if ($isNewCustomer) {
                                                        $currentCustomer = $customer->cus_fullname;
                                                        $firstProduct = true;
                                                    }
                                                @endphp
                                                
                                                <tr class="{{ $bgColorClass }}">
                                                    @if ($firstProduct)
                                                        {{-- แสดงข้อมูลลูกค้าและสินค้าแรก --}}
                                                        <td>{{ $index === 0 && $productIndex === 0 ? $serviceName : '' }}</td>
                                                        <td>{{ $customer->cus_fullname }}</td>
                                                        <td class="text-center">-</td>
                                                        <td>{{ $isIct ? $ictData->id_card ?? 'ไม่ระบุ' : $customer->id_card ?? 'ไม่ระบุ' }}</td>
                                                        <td>{{ $customer->cus_address ?? 'ไม่ระบุ' }}</td>
                                                        <td>{{ $customer->center->center_name ?? 'ไม่ระบุ' }}</td>
                                                        <td>{{ $isIct ? $ictData->customer_type ?? 'ไม่ระบุ' : $customer->type->type_name ?? 'ไม่ระบุ' }}</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>{{ $ictData->note ?? ($customer->other ?? 'ไม่ระบุ') }}</td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                                        <td class="text-end">{{ number_format($product->pivot->price) }}</td>
                                                        <td class="text-end">{{ number_format($product->pivot->quantity * $product->pivot->price) }}</td>
                                                        <td class="text-end">{{ number_format($ictData->income ?? 0) }}</td>
                                                        <td class="text-center">-</td>
                                                        @php
                                                            $firstProduct = false;
                                                        @endphp
                                                    @else
                                                        {{-- แสดงเฉพาะข้อมูลสินค้าในแถวถัดไป โดยเว้นคอลัมน์อื่นๆ ว่างไว้ --}}
                                                        <td colspan="12"></td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                                        <td class="text-end">{{ number_format($product->pivot->price) }}</td>
                                                        <td class="text-end">{{ number_format($product->pivot->quantity * $product->pivot->price) }}</td>
                                                        <td></td>
                                                        <td class="text-center">-</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="{{ $bgColorClass }}">
                                                <td>{{ $index === 0 ? $serviceName : '' }}</td>
                                                <td>{{ $customer->cus_fullname }}</td>
                                                <td class="text-center">-</td>
                                                <td>{{ $customer->id_card ?? 'ไม่ระบุ' }}</td>
                                                <td>{{ $customer->cus_address ?? 'ไม่ระบุ' }}</td>
                                                <td>{{ $customer->center->center_name ?? 'ไม่ระบุ' }}</td>
                            
                                                @if ($isFttx)
                                                    <td>{{ $fttxData->new == 1 ? 'ลูกค้าใหม่' : ($fttxData->new == 2 ? 'ลูกค้าย้ายค่าย' : 'ปรับโปรโมชั่น') }}</td>
                                                    <td>{{ $fttxData->installation_type == 1 ? 'ติดตั้งเอง' : 'จ้างผู้รับเหมา' }}</td>
                                                    <td>{{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</td>
                                                    <td>{{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</td>
                                                    <td class="text-end">{{ $customer->price->price_name ?? 'ไม่ระบุ' }}</td>
                                                    <td>{{ $fttxData->note ?? ($customer->other ?? 'ไม่ระบุ') }}</td>
                                                @elseif($isSim)
                                                    <td>{{ $simmyData->cus_new == 1 ? 'ลูกค้าใหม่' : 'ลูกค้า(ย้ายค่าย)' }}</td>
                                                    <td>-</td>
                                                    <td>{{ $customer->promotion->promotion_name ?? 'ไม่ระบุ' }}</td>
                                                    <td>{{ $customer->speed->speed_name ?? 'ไม่ระบุ' }}</td>
                                                    <td class="text-end">{{ $customer->price->price_name ?? 'ไม่ระบุ' }}</td>
                                                    <td>{{ $simmyData->note ?? ($customer->other ?? 'ไม่ระบุ') }}</td>
                                                @else
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{ $customer->other ?? 'ไม่ระบุ' }}</td>
                                                @endif
                            
                                                <td>-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-end">
                                                    @if ($isIct && $ictData)
                                                        {{ number_format($ictData->income ?? 0) }}
                                                    @else
                                                        <p class="text-center">-</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                            
                            {{-- แสดงข้อมูล TopUp แยกต่างหาก --}}
                            @if ($TopUp->count() > 0)
                                @foreach ($TopUp as $index => $topUpItem)
                                    <tr class="{{ $bgColorClasses['TopUp'] ?? 'bg-light-yellow' }}">
                                        <td>{{ $index === 0 ? 'เติมเงิน' : '' }}</td>
                                        <td>-</td>
                                        <td class="text-center">{{ $topUpItem->phone ?? 'ไม่ระบุ' }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ $topUpItem->center->center_name ?? 'ไม่ระบุ' }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">{{ number_format($topUpItem->amount ?? 0) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            
                            @if ($data->count() == 0 && $TopUp->count() == 0)
                                <tr>
                                    <td colspan="18" class="text-center">ไม่มีข้อมูลลูกค้า</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
