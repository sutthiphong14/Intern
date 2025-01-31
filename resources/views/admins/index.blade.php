<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ URL::asset(path: 'plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- Theme style -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('dist/assets/img/favicon/favicon.png') }}" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('dist/assets/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('dist/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('dist/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('dist/assets/css/demo.css') }}" />


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dist/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/assets/vendor/libs/apex-charts/apex-charts.css') }}" />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('dist/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('dist/assets/js/config.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        @yield('css') <!-- ย้ายมาไว้ตรงนี้หลังจากโหลด CSS หลัก -->
        
</head>

<body class="hold-transition layout-fixed ">
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
        @include('admins.layout-menu')
        <div class="layout-page">
        
        
        
        
        <div class="container-xxl flex-grow-1 container-p-y">
        @include('admins.layout-Navbar')
                @yield('content')
                @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                </div>
            @include('admins.footer')
        </div>
        </div>


    </div>
    <script src="{{ asset('dist/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('dist/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('dist/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('dist/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('dist/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('dist/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('dist/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('dist/assets/js/dashboards-analytics.js') }}"></script>


    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
<!-- jQuery -->
<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ URL::asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ URL::asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ URL::asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- BS-Stepper -->
<script src="{{ URL::asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>

<!-- Page specific script -->
<!-- ChartJS -->
<script src="{{ URL::asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Yield section for additional scripts -->
@yield('script')


</html>