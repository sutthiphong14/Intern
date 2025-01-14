@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มโปรโมชัน</h2>
    <form action="{{ route('promotionactivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="promotion_name" class="form-label">ชื่อโปรโมชัน</label>
            <input type="text" class="form-control" id="promotion_name" name="promotion_name" required>
            <input type="hidden" class="form-control" id="speed_id" name="speed_id" required>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
