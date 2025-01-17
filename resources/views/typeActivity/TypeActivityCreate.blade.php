@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>เพิ่มกิจกรรม</h2>
        <form action="{{ route('type_insert') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
                <input type="text" class="form-control" id="type_name" name="type_name" required>
                <input type="hidden" name="created_at" value="{{ \Carbon\Carbon::now() }}">
                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
