<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body style="background-color: #666666;">
    <div id="app">

        @yield('content')
    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('/plugins/jquery/jQuery-2.1.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/main.js') }}" type="text/javascript"></script>
</body>
</html>
