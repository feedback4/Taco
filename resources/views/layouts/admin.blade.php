<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ global_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ global_asset('css/app.css') }}" rel="stylesheet">


    @livewireStyles
    @toastr_css
    @yield('meta')
</head>

<body class="sidebar-mini" style="height: auto;">


<div class="wrapper">


    @include('layouts._navbar')

   @include('layouts._sidebar')


    <div class="content-wrapper " style="min-height: 404px;">


        <div class="content-header">
            <div class="container-fluid">
              @yield('content_header')
            </div>
        </div>


        <div class="content">
            <div class="container-fluid">

                @yield('content')
            </div>
        </div>

    </div>


    <div id="sidebar-overlay"></div>
</div>




@yield('js')


<!-- Livewire Scripts -->

@livewireScripts
@jquery
@toastr_js
@toastr_render


<!-- Alpine v3 -->

<script>
    window.livewire.on('alert', param => {
        toastr[param['type']](param['message']);
    });
</script>
</body>
</html>
