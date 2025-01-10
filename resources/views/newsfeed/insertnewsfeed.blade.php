@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection
@section('header')
รายการข้อมูล
@endsection
@section('css')

@endsection
@section('content')

<div class="card card-warning mt-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">เพิ่มเอกสาร</h3>
    </div>

    <hr class="my-2" />

    <!-- /.card-header -->
    <div class="card-body">
    <form action="{{ route('createnews') }}" class="form-group" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">หัวข้อ</label>
            <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
            @error('name')
                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">คำอธิบาย</label>
            <input class="form-control" type="text" placeholder="Description" name="description" value="{{ old('description') }}">
            @error('description')
                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="categories">หมวดหมู่</label>
            <select class="form-control" name="categories" required>
                <option value="" disabled selected>เลือกหมวดหมู่</option>
                <option value="ข่าว" {{ old('categories') == 'ข่าว' ? 'selected' : '' }}>ข่าว</option>
                <option value="เอกสาร" {{ old('categories') == 'เอกสาร' ? 'selected' : '' }}>เอกสาร</option>
            </select>
            @error('categories')
                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="file">ไฟล์</label>
            <input class="form-control" type="file" id="import_file" name="file">
            @error('file')
                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
            @enderror
        </div>

    
</div>


    </tbody>
    </table>

    <div class="col-12 mb-3 text-center">
        <a href="/listnewsfeed" class="btn bg-danger">
            Cancel
        </a>
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
    </form>
</div>
<!-- /.card-body -->


@endsection

@section('script')

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection