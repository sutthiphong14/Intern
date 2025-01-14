@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>แก้ไขราคา</h2>
    <form action="{{ route('priceactivityupdate', $data->price_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="price_name" class="form-label">ชื่อราคา</label>
            <input type="text" class="form-control" id="price_name" name="price_name" value="{{ $data->price_name }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('priceactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
