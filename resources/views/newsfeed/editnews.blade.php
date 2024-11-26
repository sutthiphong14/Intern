@extends('admins.index')
@section('title')
    รายการข้อมูล
@endsection
@section('header')
    รายการข้อมูล
@endsection
@section('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-warning mt-2 ">
                        <div class="card-header d-flex justify-content-between align-items-center ">
                            <h3 class="card-title ">เพิ่มเอกสาร </h3>


                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">


                            <table id="example2" class="table table-bordered ">
                                <thead class="text-center">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Upload</th>
                                    </tr>
                                </thead>
                                <tbody class="align-items-center">
                                    <form action="{{ route('updatenews', $oldnews->id) }}" class="form-group" method="POST">
                                        @csrf
                                        <tr>
                                            <td>
                                                <input class="form-control" type="text" placeholder="Name" name="name"
                                                    value="{{ $oldnews->name }}">
                                                @error('name')
                                                    <p class="text-danger my-2"><i
                                                            class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                                @enderror
                                            </td>
                                            <td>
                    
                                                    <textarea name="description"  cols="30" rows="5">{{ $oldnews->description }}</textarea>
                                                @error('description')
                                                    <p class="text-danger my-2"><i
                                                            class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                                @enderror
                                            </td>

                                            <div class="form-group">
                                                <td>
                                                    <select class="form-control" name="category_id">
                                                        <option value="" disabled {{ is_null(old('category_id', $oldnews->category_id)) ? 'selected' : '' }}>
                                                            เลือก Category
                                                        </option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" 
                                                                {{ old('category_id', $oldnews->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                    <p class="text-danger my-2">
                                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                                    </p>
                                                    @enderror
                                                </td>

                                            </div>


                                            <td>
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <textarea cols="30" rows="5" class="form-control" type="text" placeholder="Link" name="link">{{ $oldnews->link }}</textarea>
                                                    </div>
                                                </div>
                                                @error('link')
                                                    <p class="text-danger my-2"><i
                                                            class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                                @enderror
                                            </td>
                                        </tr>


                                </tbody>
                            </table>
                        </div>

                        </tbody>


                        </table>

                        <div class="col-12 mb-3 text-center ">
                            <a href="/listnewsfeed" class="btn bg-danger ">
                                Cancel
                            </a>
                            <input type="submit" class=" btn btn-success" value="Submit">

                        </div>
                        </form>



                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
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
