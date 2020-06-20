<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    <script src="{{ asset(mix('js/app.js'))}}" defer></script>
    <script src="{{ asset(mix('js/manifest.js'))}}" defer></script>
    <script src="{{ asset(mix('js/vendor.js'))}}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset(mix('css/app.css'))}}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>

<div id="app">
    @section('navBar')
        @include('layouts.layoutsChunk.nav')
    @show

    @section('fleshMessage')
        @include('layouts.layoutsChunk.flashMessage')
    @show
    <main role="main" class="container">
        <div class="row">

            @yield('content')

            @section('aside')
            @show
        </div>
    </main>
    @section('footer')
        @include('layouts.layoutsChunk.footer')
    @show
</div>
</body>
</html>
