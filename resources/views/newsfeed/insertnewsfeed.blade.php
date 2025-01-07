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

    <!-- /.card-header -->
    <div class="card-body">
        <table id="example2" class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>หัวข้อข่าว</th>
                    <th>คำอธิบาย</th>
                    <th>ไฟล์</th>
                </tr>
            </thead>
            <tbody class="align-items-center">
                <form action="{{ route('createnews') }}" class="form-group" method="POST" enctype="multipart/form-data">
                    @csrf
                    <tr>
                        <td>
                            <input class="form-control" type="text" placeholder="Name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </td>
                        <td>
                            <input class="form-control" type="text" placeholder="Description" name="description"
                                value="{{ old('description') }}">
                            @error('description')
                                <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                            @enderror
                        </td>

                        <td>
                            <div class="form-group">
                                <div class="row">
                                    <input class="form-control" type="file" id="import_file" name="file">
                                   
                                </div>

                                @error('file')
                                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </td>
                    </tr>
            </tbody>
        </table>
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