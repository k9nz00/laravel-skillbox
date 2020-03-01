<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--scripts and styles--}}
    <link rel="icon" href="/favicon.ico">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>

<div id="app">
    @include('layouts.layoutsChunk.nav')
    @section('fleshMessage')
        @include('layouts.layoutsChunk.flashMessage')
    @show
    <main role="main" class="container">
        <div class="row">

            @yield('content')

            @section('aside')
                @include('layouts.layoutsChunk.aside')
            @show
        </div>
    </main>
    @include('layouts.layoutsChunk.footer')
</div>
</body>
</html>
