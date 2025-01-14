@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มข้อมูลศูนย์บริการ</h2>
    <form action="{{ route('servicecenteractivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="center_name" class="form-label">ชื่อศูนย์บริการ</label>
            <input type="text" class="form-control" id="center_name" name="center_name" required>
           
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('servicecenteractivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
