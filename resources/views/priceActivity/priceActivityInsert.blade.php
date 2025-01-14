@extends('admins.index')
@section('css')
@endsection

@section('content')
<div class="container">
    <h2>เพิ่มราคา</h2>
    <form action="{{ route('priceactivityadd') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="price_name" class="form-label">ชื่อราคา</label>
            <input type="text" class="form-control" id="price_name" name="price_name" required>
           
        </div>
        
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('priceactivityList') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
