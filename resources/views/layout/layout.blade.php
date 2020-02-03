<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>

@include('layout.layoutsChunk.nav')
<main role="main" class="container">
    <div class="row">
        @yield('content')

        @include('layout.layoutsChunk.aside')
    </div>
</main>
@include('layout.layoutsChunk.footer')
</body>
</html>
