@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มความเร็ว</h2>
    <form action="{{ route('speedactivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="speed_name" class="form-label">ชื่อความเร็ว</label>
            <input type="text" class="form-control" id="speed_name" name="speed_name" required>
            <input type="hidden" class="form-control" id="price_id" name="price_id" required>
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
      <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

    </form>
</div>
@endsection
