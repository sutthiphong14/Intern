@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <div class="mt-5 d-flex">
            <h3>สรุปผลการดำเนินงานกิจกรรมการตลาด {{ $types->type_name }} </h3>
            <h3 class="text-warning">จังหวัด{{ $provinces->province_name }}</h3>

        </div>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ดูข้อมูล</th>
                    <th rowspan="4">ศูยน์บริกาาร</th>
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
                @foreach ($centers as $center)
                    {{-- Province ID <= 33 --}}
                        <tr>
                            <td>
                                <a href="#" class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </a>                                
                             
                            </td>
                            <td>{{ $center->center_name }}</td>
                            <td>{{ $fttxNew[$center->center_id] ?? 0 }}</td>
                            <td>{{ $selfInstall[$center->center_id] ?? 0 }}</td>
                            <td>{{ $HireInstall[$center->center_id] ?? 0 }}</td>
                            
                            <td>{{ $Simmy_new[$center->center_id] ?? 0 }}</td>
                            <td>{{ $Simmy_move[$center->center_id] ?? 0 }}</td>
                            <td>{{ $Simmy_count[$center->center_id] ?? 0 }}</td>
                            <td>{{ $Simmy_price[$center->center_id] ?? 0 }}</td>
                            <td>{{ $Ict_count[$center->center_id] ?? 0 }}</td>
                            <td>{{ $Ict_income[$center->center_id] ?? 0 }}</td>
                            
                            
                        </tr>
                        @endforeach
            </tbody>



        </table>
    </div>
@endsection
