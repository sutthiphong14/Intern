@extends('admins.index')
@section('title')
    เพิ่มหมวดหมู่
@endsection
@section('header')
    เพิ่มหมวดหมู่
@endsection
@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning mt-2">
                    <div class="card-header">
                        <h3 class="card-title">เพิ่มหมวดหมู่ใหม่</h3>
                    </div>
                    
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">ชื่อหมวดหมู่</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       placeholder="กรอกชื่อหมวดหมู่" required value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-danger" 
                                    onclick="window.location='{{ route('categories.listcategories') }}'">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection