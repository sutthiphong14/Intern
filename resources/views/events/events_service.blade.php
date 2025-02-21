@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="mt-5 d-flex justify-content-between">
            <h3>สรุปผลการดำเนินงานกิจกรรมการตลาด  {{ $types->type_name }} <br>@if ($province_id == 1)
                    ตป.1
                @else
                    ตป.2
                @endif
            </h3>
            <a class="btn btn-secondary mb-3 text-white"
                href="{{ route('event_customer', $types->type_id) }}">ดูข้อมูลลูกค้า</a>
        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ดูข้อมูล</th>
                    <th rowspan="4">จังหวัด</th>
                    <th colspan="3">FTTX</th>
                    <th colspan="4">SIM my</th>
                    <th colspan="2">Ict Solution</th>

                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="4">new</th>
                    <th rowspan="4">ติดตั้งเอง</th>
                    <th rowspan="4">จ้างผู้รับเหมา</th>

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
                @foreach ($provinces as $province)
                    {{-- Province ID <= 33 --}}
                    @if ($province->province_id <= 12)
                        <tr>
                            <td>
                                <a href="{{ route('event_center', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                    class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                        </tr>
                    @endif
                    {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
                    @if ($province->province_id == 12)
                        <tr class="bg-warning">
                            <td colspan="2">รวม ตป.1</td>
                            <td>{{ $sumFttxNew }}</td>
                            <td>{{ $sumSelfInstall }}</td>
                            <td>{{ $sumHireInstall }}</td>

                            <td>{{ $sumNew }}</td>
                            <td>{{ $sumMove }}</td>
                            <td>{{ $sumCount }}</td>
                            <td>{{ $sumPrice }}</td>
                            <td>{{ $IctCount }}</td>
                            <td>{{ $IctIncome }}</td>
                        </tr>
                    @endif
                    {{-- Province ID > 33 --}}
                    @if ($province->province_id > 12)
                        <tr>
                            <td>
                                <a href="{{ route('event_center', ['province_id' => $province->province_id, 'type_id' => $types->type_id]) }}"
                                    class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                            <td>{{ $province->province_name }}</td>
                            <td>{{ $fttxNew[$province->province_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$province->province_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$province->province_id] ?? 0 }}</td>

                            <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$province->province_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$province->province_id] ?? 0 }}</td>
                        </tr>
                    @endif
                @endforeach
                @if ($province->province_id > 12)
                {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.2</td>
                    <td>{{ $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstallOver33 }}</td>

                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                    <td>{{ $IctCountOver33 }}</td>
                    <td>{{ $IctIncomeOver33 }}</td>
                </tr>
                @endif

                <tr class="bg-success">
                    <td colspan="2">รวม ทั้งหมด</td>
                    <td>{{ $sumFttxNew + $sumFttxNewOver33 }}</td>
                    <td>{{ $sumSelfInstall + $sumSelfInstallOver33 }}</td>
                    <td>{{ $sumHireInstall + $sumHireInstallOver33 }}</td>
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
@endsection
