@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มกิจกกรรม</h2>
    <form action="{{ route('typeactivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="type_name" name="type_name" required>
            <input type="hidden" class="form-control" id="service_id" name="service_id" required>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('typeactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
