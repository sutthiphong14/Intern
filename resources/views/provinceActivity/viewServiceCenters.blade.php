@extends('admins.index')
@section('content')
<div class="container">
    <h2>ศูนย์บริการในจังหวัด {{ $province->province_name }}</h2>
    <div class="mb-3">
        <a href="{{ route('province.createServiceCenter', $province->province_id) }}" class="btn btn-primary">เพิ่มศูนย์บริการ</a>
        <a href="{{ route('provinceactivityList') }}" class="btn btn-secondary">กลับ</a>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อศูนย์บริการ</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            @if($province->centers->count() > 0)
                @foreach($province->centers as $center)
                    <tr>
                        <td>{{ $center->center_name }}</td>
                        <td>
                            <a href="{{ route('servicecenteractivityedit', $center->center_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                            <form action="{{ route('servicecenteractivitydelete', $center->center_id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">ไม่พบข้อมูลศูนย์บริการ</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection