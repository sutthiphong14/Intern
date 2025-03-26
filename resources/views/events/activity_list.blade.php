<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="mt-5">
            <h3>สรุปรายงานผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }}</h3>
        </div>
        <table class="table table-bordered table-sm ">
            <thead>
                <tr class="bg-dark text-white text-center">
                    <th rowspan="3" class="align-middle">ลำดับ</th>
                    <th rowspan="3" class="align-middle">จังหวัด</th>
                    <th colspan="5" class="text-center">FTTX</th>
                    <th colspan="4" class="text-center">SIM my</th>
                    <th colspan="16" class="text-center">Ict Solution</th>
                </tr>
                <tr class="bg-dark text-white text-center">
                    <th rowspan="2" class="align-middle">new</th>
                    <th rowspan="2" class="align-middle">ติดตั้งเอง</th>
                    <th rowspan="2" class="align-middle">จ้างผู้รับเหมา</th>
                    <th rowspan="2" class="align-middle">ปรับโปรโมชั่น</th>
                    <th rowspan="2" class="align-middle">ลูกค้าย้ายค่าย</th>
                    <th rowspan="2" class="align-middle">ลูกค้าใหม่</th>
                    <th rowspan="2" class="align-middle">ลูกค้า (ย้ายค่าย)</th>
                    <th colspan="2" class="text-center">เติมเงินรายปี</th>
                    <th rowspan="2">จำนวน (ราย)</th>
                    <th rowspan="2">รายได้</th>
                    <th colspan="2">CCTV</th>
                    <th colspan="2">smart pole</th>
                    <th colspan="2">internet wifi</th>
                    <th colspan="2">smart office</th>
                    <th colspan="2">cyber security</th>
                    <th colspan="2">ultimate connect</th>
                    <th colspan="2">บริการอื่นๆ</th>
                </tr>
                <tr class="bg-dark text-white text-center">
                    <th class="text-center">จำนวน (ราย)</th>
                    <th class="text-center">ยอดเงิน</th>

                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                    <th>จำนวนจุดติดตั้ง</th>
                    <th>รายได้</th>
                </tr>
            </thead>
            @php
                $sumFttxNew = $sumSelfInstall = $sumHireInstall = $sumAdjust = $sumfttxMove = 0; // สำหรับ province_id <= 33
                $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = $sumAdjustOver33 = $sumfttxMoveOver33 = 0; // สำหรับ province_id > 33

                $sumNew = $sumMove = $sumCount = $sumPrice = 0; // สำหรับ province_id <= 33
                $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0; // สำหรับ province_id > 33
                $IctCount = $IctIncome = 0; // สำหรับ province_id <= 33
                $IctCountOver33 = $IctIncomeOver33 = 0; // สำหรับ province_id > 33

                // เตรียมตัวแปรสำหรับรวมข้อมูลบริการ
                $group1ServiceTotals = [];
                $group2ServiceTotals = [];

                foreach ($serviceNames as $serviceName) {
                    $group1ServiceTotals[$serviceName] = ['total_quantity' => 0, 'total_price' => 0];
                    $group2ServiceTotals[$serviceName] = ['total_quantity' => 0, 'total_price' => 0];
                }
            @endphp


            <tbody class="text-center">
                @foreach ($provinces as $index => $province)
                    @php
                        if ($province->province_id <= 12) {
                            foreach ($serviceNames as $serviceName) {
                                $quantity =
                                    $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                $group1ServiceTotals[$serviceName]['total_quantity'] += $quantity;
                                $group1ServiceTotals[$serviceName]['total_price'] += $price;
                            }
                        } else {
                            foreach ($serviceNames as $serviceName) {
                                $quantity =
                                    $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                $group2ServiceTotals[$serviceName]['total_quantity'] += $quantity;
                                $group2ServiceTotals[$serviceName]['total_price'] += $price;
                            }
                        }
                    @endphp
                    {{-- Province ID <= 33 --}}
                    @if ($province->province_id <= 12)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $adjust[$province->province_id] ?? 0 }}</td>
                            <td>{{ $move[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                            <!-- เพิ่มต่อจากคอลัมน์ Ict_income -->
                            @foreach ($serviceNames as $serviceName)
                                @php
                                    $quantity =
                                        $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                    $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                @endphp
                                <td>{{ number_format($quantity, 0) }}</td>
                                <td>{{ number_format($price) }}</td>
                            @endforeach
                        </tr>

                        @php
                            $sumFttxNew += $fttxNew[$province->province_id] ?? 0;
                            $sumSelfInstall += $selfInstall[$province->province_id] ?? 0;
                            $sumHireInstall += $HireInstall[$province->province_id] ?? 0;
                            $sumAdjust += $adjust[$province->province_id] ?? 0;
                            $sumfttxMove += $move[$province->province_id] ?? 0;
                            $sumNew += $Simmy_new[$province->province_id] ?? 0;
                            $sumMove += $Simmy_move[$province->province_id] ?? 0;
                            $sumCount += $Simmy_count[$province->province_id] ?? 0;
                            $sumPrice += $Simmy_price[$province->province_id] ?? 0;
                            $IctCount += $Ict_count[$province->province_id] ?? 0;
                            $IctIncome += $Ict_income[$province->province_id] ?? 0;
                        @endphp
                    @endif
                    {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                    @if ($province->province_id == 12)
                        <tr class="bg-warning">
                            <td colspan="2">รวม ตป.1</td>
                            <td>{{ $sumFttxNew }}</td>
                            <td>{{ $sumSelfInstall }}</td>
                            <td>{{ $sumHireInstall }}</td>
                            <td>{{ $sumAdjust }}</td>
                            <td>{{ $sumfttxMove }}</td>

                            <td>{{ $sumNew }}</td>
                            <td>{{ $sumMove }}</td>
                            <td>{{ $sumCount }}</td>
                            <td>{{ $sumPrice }}</td>
                            <td>{{ $IctCount }}</td>
                            <td>{{ $IctIncome }}</td>
                            <!-- แสดงผลรวมในแถวสรุปกลุ่มที่ 1 -->
                            @foreach ($serviceNames as $serviceName)
                                <td>{{ number_format($group1ServiceTotals[$serviceName]['total_quantity'], 0) }}</td>
                                <td>{{ number_format($group1ServiceTotals[$serviceName]['total_price']) }}</td>
                            @endforeach

                        </tr>
                    @endif
                    {{-- Province ID > 33 --}}
                    @if ($province->province_id > 12)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $adjust[$province->province_id] ?? 0 }}</td>
                            <td>{{ $move[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                            <!-- เพิ่มต่อจากคอลัมน์ Ict_income -->
                            @foreach ($serviceNames as $serviceName)
                                @php
                                    $quantity =
                                        $provinceSummary[$province->province_id][$serviceName]['total_quantity'] ?? 0;
                                    $price = $provinceSummary[$province->province_id][$serviceName]['total_price'] ?? 0;
                                @endphp
                                <td>{{ number_format($quantity, 0) }}</td>
                                <td>{{ number_format($price) }}</td>
                            @endforeach
                        </tr>
                        @php
                            $sumFttxNewOver33 += $fttxNew[$province->province_id] ?? 0;
                            $sumSelfInstallOver33 += $selfInstall[$province->province_id] ?? 0;
                            $sumHireInstallOver33 += $HireInstall[$province->province_id] ?? 0;
                            $sumAdjustOver33 += $adjust[$province->province_id] ?? 0;
                            $sumfttxMoveOver33 += $move[$province->province_id] ?? 0;
                            $sumNewOver33 += $Simmy_new[$province->province_id] ?? 0;
                            $sumMoveOver33 += $Simmy_move[$province->province_id] ?? 0;
                            $sumCountOver33 += $Simmy_count[$province->province_id] ?? 0;
                            $sumPriceOver33 += $Simmy_price[$province->province_id] ?? 0;
                            $IctCountOver33 += $Ict_count[$province->province_id] ?? 0;
                            $IctIncomeOver33 += $Ict_income[$province->province_id] ?? 0;
                        @endphp
                    @endif
                @endforeach

                {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.2</td>
                    <td>{{ $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstallOver33 }}</td>
                    <td>{{ $sumAdjustOver33 }}</td>
                    <td>{{ $sumfttxMoveOver33 }}</td>

                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                    <td>{{ $IctCountOver33 }}</td>
                    <td>{{ $IctIncomeOver33 }}</td>
                    <!-- แสดงผลรวมในแถวสรุปกลุ่มที่ 2 -->
                    @foreach ($serviceNames as $serviceName)
                        <td>{{ number_format($group2ServiceTotals[$serviceName]['total_quantity'], 0) }}</td>
                        <td>{{ number_format($group2ServiceTotals[$serviceName]['total_price']) }}</td>
                    @endforeach


                </tr>

                <tr class="bg-success">
                    <td colspan="2">รวม ทั้งหมด</td>
                    <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
                    <td>{{ $sumAdjust + $sumAdjustOver33 }}</td>
                    <td>{{ $sumfttxMove + $sumfttxMoveOver33 }}</td>

                    <td>{{ $sumNew + $sumNewOver33 }}</td>
                    <td>{{ $sumMove + $sumMoveOver33 }}</td>
                    <td>{{ $sumCount + $sumCountOver33 }}</td>
                    <td>{{ $sumPrice + $sumPriceOver33 }}</td>
                    <td>{{ $IctCount + $IctCountOver33 }}</td>
                    <td>{{ $IctIncome + $IctIncomeOver33 }}</td>
                    <!-- แสดงผลรวมทั้งหมด -->
                    @foreach ($serviceNames as $serviceName)
                        <td>{{ number_format($group1ServiceTotals[$serviceName]['total_quantity'] + $group2ServiceTotals[$serviceName]['total_quantity'], 0) }}
                        </td>
                        <td>{{ number_format($group1ServiceTotals[$serviceName]['total_price'] + $group2ServiceTotals[$serviceName]['total_price']) }}
                        </td>
                    @endforeach
                </tr>
            </tbody>



        </table>














    </div>

</body>
