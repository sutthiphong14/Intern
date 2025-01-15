@extends('admins.index')
@section('css')
@endsection
@section('content')
<div class="container">
    <h2>จัดการข้อมูลจังหวัด</h2>
    <a href="{{ route('provinceactivitylnsert') }}" class="btn btn-primary mb-3">เพิ่มจังหวัด</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ชื่อจังหวัด</th>             
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->province_name }}</td>                    
                    <td>
                        <a href="{{ route('provinceactivityedit', $row->province_id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                        <form action="{{ route('provinceactivitydelete', $row->province_id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                        </form>
                        <a href="{{ route('province.createServiceCenter', $row->province_id) }}" class="btn btn-success btn-sm">เพิ่มศูนย์บริการ</a>
                        <a href="{{ route('province.viewServiceCenters', $row->province_id) }}" class="btn btn-info btn-sm">ดูศูนย์บริการ</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection