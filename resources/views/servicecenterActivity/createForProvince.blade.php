@extends('admins.index')
@section('content')
<div class="container">
    <h2>เพิ่มศูนย์บริการสำหรับจังหวัด {{ $province->province_name }}</h2>
    
    <form action="{{ route('province.storeServiceCenter', $province->province_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="center_name">ชื่อศูนย์บริการ:</label>
            <input type="text" class="form-control" id="center_name" name="center_name" required>
        </div>
        
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="{{ route('province.viewServiceCenters', $province->province_id) }}" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection