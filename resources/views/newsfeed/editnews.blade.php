@extends('admins.index')
@section('title')
แก้ไขข้อมูล
@endsection
@section('header')
แก้ไขข้อมูล
@endsection
@section('css')

@endsection
@section('content')

<div class="card card-warning mt-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">แก้ไขเอกสาร</h3>
    </div>

    <hr class="my-2" />

    <div class="card-body">
        <form action="{{ route('updatenews', $oldnews->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">หัวข้อ</label>
                <input class="form-control" type="text" placeholder="Name" name="name"
                    value="{{ old('name', $oldnews->name) }}">
                @error('name')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">คำอธิบาย</label>
                <input class="form-control" type="text" placeholder="Description" name="description"
                    value="{{ old('description', $oldnews->description) }}">
                @error('description')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">สถานะ</label>
                <select class="form-control" name="status" id="status">
                    <option value="1" {{ $oldnews->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $oldnews->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categories">หมวดหมู่</label>
                <select class="form-control" name="categories" required>
                    <option value="" disabled>เลือกหมวดหมู่</option>
                    <option value="ข่าว" {{ old('categories', $oldnews->categories) == 'ข่าว' ? 'selected' : '' }}>ข่าว
                    </option>
                    <option value="เอกสาร" {{ old('categories', $oldnews->categories) == 'เอกสาร' ? 'selected' : '' }}>
                        เอกสาร</option>
                    <option value="แบบฟอร์ม" {{ old('categories', $oldnews->categories) == 'แบบฟอร์ม' ? 'selected' : '' }}>แบบฟอร์ม</option>
                </select>
                @error('categories')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="content_type">ประเภทข้อมูล</label>
                <select class="form-control" name="content_type" id="content_type" required>
                    <option value="" disabled>เลือกประเภทข้อมูล</option>
                    <option value="file" {{ old('content_type', $oldnews->content_type) == 'file' ? 'selected' : '' }}>
                        ไฟล์</option>
                    <option value="link" {{ old('content_type', $oldnews->content_type) == 'link' ? 'selected' : '' }}>
                        ลิงก์</option>
                    <option value="youtube" {{ old('content_type', $oldnews->content_type) == 'youtube' ? 'selected' : '' }}>วิดีโอ YouTube</option>
                </select>
                @error('content_type')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" id="file_input"
                style="display: {{ $oldnews->content_type == 'file' ? 'block' : 'none' }};">
                <label for="file">ไฟล์</label>
                <input class="form-control" type="file" name="file">
                @error('file')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" id="link_input"
                style="display: {{ $oldnews->content_type == 'link' ? 'block' : 'none' }};">
                <label for="link">ลิงก์</label>
                <input class="form-control" type="url" name="link" placeholder="https://example.com"
                    value="{{ old('link', $oldnews->link) }}">
                @error('link')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" id="youtube_input"
                style="display: {{ $oldnews->content_type == 'youtube' ? 'block' : 'none' }};">
                <label for="youtube">ลิงก์วิดีโอ YouTube</label>
                <input class="form-control" type="url" name="youtube" placeholder="https://youtube.com/watch?v=..."
                    value="{{ old('youtube', $oldnews->youtube) }}">
                @error('youtube')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="col-12 mb-3 text-center">
                <a href="/listnewsfeed" class="btn bg-danger">Cancel</a>
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')

<script>
    document.getElementById('content_type').addEventListener('change', function () {
        const value = this.value;
        document.getElementById('file_input').style.display = value === 'file' ? 'block' : 'none';
        document.getElementById('link_input').style.display = value === 'link' ? 'block' : 'none';
        document.getElementById('youtube_input').style.display = value === 'youtube' ? 'block' : 'none';
    });
</script>

@endsection