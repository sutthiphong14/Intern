@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มข้อมูลจังหวัด</h2>
    <form action="{{ route('provinceactivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="province_name" name="province_name" required>
            <input type="hidden" class="form-control" id="center_id" name="center_id" required>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('provinceactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
