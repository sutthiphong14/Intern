@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขบริการ</h2>
    <form action="{{ route('serve.update', $data->service_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="service_name" class="form-label">ชื่อบริการ</label>
            <input type="text" class="form-control" id="service_name" name="service_name" value="{{ $data->service_name }}" required>
        </div>
        <div class="mb-3">
            <label for="promotion_id" class="form-label">Promotion</label>
            <select class="form-control" id="promotion_id" name="promotion_id" required>
                @foreach ($foreignData as $promotion)
                    <option value="{{ $promotion->promotion_id }}" 
                        {{ $data->promotion_id == $promotion->promotion_id ? 'selected' : '' }}>
                        {{ $promotion->promotion_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('severactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
