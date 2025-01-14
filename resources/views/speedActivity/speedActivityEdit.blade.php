@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขความเร็ว</h2>
    <form action="{{ route('speedactivityupdate', $data->speed_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="speed_name" class="form-label">ชื่อความเร็ว</label>
            <input type="text" class="form-control" id="speed_name" name="speed_name" value="{{ $data->speed_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('speedactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
