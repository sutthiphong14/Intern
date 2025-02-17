@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการกิจกรรม</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">
            เพิ่มกิจกรรม
        </button>

        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ลำดับ</th>
                    <th rowspan="4">ชื่อกิจกรรม</th>
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
            <tbody>

                @foreach ($sumByType as $data)
                    <tr class="bg-success">
                        <td>แว่น</td>
                        <td colspan="1">ใใใใ</td>
                        <td>{{ $data['fttxNew'] ?? 0 }}</td>
                        <td>{{ $data['selfInstall'] ?? 0 }}</td>
                        <td>{{ $data['hireInstall'] ?? 0 }}</td>
                        <td>{{ $data['new'] ?? 0 }}</td>
                        <td>{{ $data['move'] ?? 0 }}</td>
                        <td>{{ $data['count'] ?? 0 }}</td>
                        <td>{{ $data['price'] ?? 0 }}</td>
                        <td>{{ $data['ictCount'] ?? 0 }}</td>
                        <td>{{ $data['ictIncome'] ?? 0 }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endsection
