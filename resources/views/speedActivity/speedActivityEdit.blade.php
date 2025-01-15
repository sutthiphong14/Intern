@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขความเร็ว</h2>
    <form action="{{ route('speed_update', ['promotion_id' => $promotion_id, 'speed_id' => $speed_id,'service_id' => $service_id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="speed_name" class="form-label">ชื่อความเร็ว</label>
            <input type="text" class="form-control" id="speed_name" name="speed_name" value="{{ $data->speed_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
