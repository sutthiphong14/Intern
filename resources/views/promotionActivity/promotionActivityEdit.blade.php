@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขโปรโมชัน</h2>
    <form action="{{ route('promotionactivityupdate', $data->promotion_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="promotion_name" class="form-label">ชื่อโปรโมชัน</label>
            <input type="text" class="form-control" id="promotion_name" name="promotion_name" value="{{ $data->promotion_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('promotionactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
