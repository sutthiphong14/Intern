@extends('admins.index')
@section('css')
@endsection

@section('content')
<h5 id="sim_my">SIM my</h5>
<table class="table table-bordered text-center" >
    <thead>
        <tr class="bg-dark">
            <th rowspan="3">ลำดับ</th>
            <th rowspan="3">จังหวัด</th>
            <th colspan="5" rowspan="1">SIM my</th>
           
        </tr>
        <tr class="bg-dark">
            <th rowspan="2">ลูกค้าใหม่</th>
            <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
            <th colspan="3">เติมเงินรายปี</th>
        
        
        </tr>
        <tr class="bg-dark">
            <th>จำนวน
                 (ราย)</th>
            <th>ยอดเงิน</th>
         
        </tr>
    </thead>

    @php
        $sumNew = $sumMove = $sumCount = $sumPrice  = 0; // สำหรับ province_id <= 33
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0; // สำหรับ province_id > 33
    @endphp
    <tbody class="text-center">
        @foreach ($provinces as $index => $province)
            {{-- Province ID <= 33 --}}
            @if ($province->province_id <= 12)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $province->province_name }}</td>
                    <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                </tr>
                @php
                    $sumNew += $Simmy_new[$province->province_id] ?? 0;
                    $sumMove += $Simmy_move[$province->province_id] ?? 0;
                     $sumCount += $Simmy_count[$province->province_id] ?? 0;
                     $sumPrice += $Simmy_price[$province->province_id] ?? 0;
                 @endphp
            @endif

            {{-- แสดงผลรวมตรงกลางเมื่อเปลี่ยนกลุ่ม --}}
            @if ($province->province_id == 12)
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.1</td>
                    <td>{{ $sumNew }}</td>
                    <td>{{ $sumMove }}</td>
                    <td>{{ $sumCount }}</td>
                    <td>{{ $sumPrice }}</td>
                </tr>
            @endif

            {{-- Province ID > 33 --}}
            @if ($province->province_id > 12)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $province->province_name }}</td>
                    <td>{{ $Simmy_new[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_move[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_count[$province->province_id] ?? 0 }}</td>
                    <td>{{ $Simmy_price[$province->province_id] ?? 0 }}</td>
                </tr>
                @php
                $sumNewOver33 += $Simmy_new[$province->province_id] ?? 0;
                $sumMoveOver33 += $Simmy_move[$province->province_id] ?? 0;
                 $sumCountOver33 += $Simmy_count[$province->province_id] ?? 0;
                 $sumPriceOver33 += $Simmy_price[$province->province_id] ?? 0;
             @endphp
               
            @endif
        @endforeach

        {{-- แสดงผลรวมสำหรับ province_id > 33 --}}
        @if ($province->province_id > 12)
                <tr class="bg-warning">
                    <td colspan="2">รวม ตป.2</td>
                    <td>{{ $sumNewOver33 }}</td>
                    <td>{{ $sumMoveOver33 }}</td>
                    <td>{{ $sumCountOver33 }}</td>
                    <td>{{ $sumPriceOver33 }}</td>
                </tr>
            @endif

        <tr class="bg-success">
            <td colspan="2">รวม ทั้งหมด</td>
            <td>{{ $sumNew + $sumNewOver33 }}</td>
            <td>{{ $sumMove  + $sumMoveOver33 }}</td>
            <td>{{ $sumCount  + $sumCountOver33}}</td>
            <td>{{ $sumPrice  + $sumPriceOver33}}</td>
        </tr>
    </tbody>
</table>

@endsection
