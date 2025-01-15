@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขบริการ</h2>
    <form action="{{ route('serve_update', $data->service_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="service_name" class="form-label">ชื่อบริการ</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="{{ $data->service_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection