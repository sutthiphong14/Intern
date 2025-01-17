@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>แก้ไขข้อมูลจังหวัด</h2>
        <form action="{{ route('provinceactivityupdate', $data->province_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="province_name" class="form-label">ชื่อจังหวัด</label>
                <input type="text" class="form-control" id="province_name" name="province_name"
                    value="{{ $data->province_name }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
