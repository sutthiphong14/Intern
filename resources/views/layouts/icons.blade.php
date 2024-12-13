@extends('admins.index')
@section('title','icon')
@section('css')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Icons</h3>
            </div> <!-- /.card-body -->
            <div class="card-body">
                <p>You can use any font library you like with AdminLTE 3.</p>
                <strong>Recommendations</strong>
                <div>
                    <a href="https://fontawesome.com/">Font Awesome</a><br>
                    <a href="https://useiconic.com/open/">Iconic Icons</a><br>
                    <a href="https://ionicons.com/">Ion Icons</a><br>
                </div>
            </div><!-- /.card-body -->
        </div>
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('script')

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
@endsection