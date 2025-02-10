@extends('admins.index')

@section('title', 'จัดการรูปภาพกิจกรรม')

@section('content')
<h4 class="fw-bold py-2 mb-3">
    <a href="{{ route('events.list') }}">จัดการกิจกรรม</a> / จัดการรูปภาพกิจกรรม
</h4>

<h5>{{ $event->nameevent }}</h5>

<!-- แสดงรูปภาพที่เกี่ยวข้องกับกิจกรรม -->
<div class="gallery">
@foreach($images as $image)
    <img src="{{ asset('storage/' . $image->image_event) }}" alt="Image" class="img-thumbnail">
@endforeach
</div>

<!-- ปุ่มสำหรับอัปโหลดรูปภาพ -->
<form action="{{ route('upload_image_event', ['event_id' => $event->event_id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="image_event">เลือกไฟล์รูปภาพ</label>
        <input type="file" name="image_event[]" id="image_event" class="form-control" multiple required>
    </div>
    <button type="submit" class="btn btn-primary">อัปโหลดรูปภาพ</button>
</form>

@endsection
