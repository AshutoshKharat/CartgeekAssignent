<!DOCTYPE html>
<html lang="{{ config('app.locale')}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>CratGeek Assignment</title>

    <link rel="stylesheet" href="{{ asset('public/asset/css/Style.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('public/asset/css/main_css.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('public/asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/asset/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/asset/font-awesome/css/font-awesome.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('public/asset/css/bootstrap.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('public/asset/font-awesome/css/dataTables.bootstrap4.min.css') }}">

    <script src="{{ asset('public/asset/js/jquery.js') }}"></script>
    <script src="{{ asset('public/asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/asset/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/asset/js/datatables.min.js') }}"></script>
    <script src="{{ asset('public/asset/js/SweetAlert_Function.js') }}"></script>
    <script src="{{ asset('public/asset/js/SweetAlert.js') }}"></script>
    <script src="{{ asset('public/asset/js/lib.js') }}"></script>

    <style>
    </style>
</head>

<body>
    @yield('content')
    @include('Navbar.Navbar')
</body>
<!-- ===== IONICONS ===== -->
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
<!-- ===== MAIN JS ===== -->
<script src="{{ asset('public/asset/js/main.js') }}"></script>
<!-- ===== MINIFY AND BEAUTIFY HTML ===== -->
<script src="{{ asset('public/asset/js/lib.js') }}"></script>
<script>
</script>

</html>
