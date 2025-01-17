@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>แก้ไขข้อมูลศูนย์บริการ</h2>
        <form action="{{ route('servicecenteractivityupdate', $data->center_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="center_name" class="form-label">ชื่อจังหวัดศูนย์บริการ</label>
                <input type="text" class="form-control" id="center_name" name="center_name" value="{{ $data->center_name }}"
                    required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
