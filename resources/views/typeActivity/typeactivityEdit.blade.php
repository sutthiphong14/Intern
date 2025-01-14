@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขกิจกรรม</h2>
    <form action="{{ route('typeactivityedit', $data->type_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
            <input type="text" class="form-control" id="type_name" name="type_name" value="{{ $data->type_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('typeactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
