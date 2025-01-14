@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มบริการ</h2>
    <form action="{{ route('serve.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="service_name" class="form-label">ชื่อบริการ</label>
            <input type="text" class="form-control" id="service_name" name="service_name" required>
            <input type="hidden" class="form-control" id="promotion_id" name="promotion_id" required>

        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
