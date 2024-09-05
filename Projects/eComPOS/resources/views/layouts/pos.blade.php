<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png"
        href="{{ getSettings('favicon_path') ? asset(getSettings('favicon_path')) : asset('public/logo/small-logo.png') }}" />
    <title>
        {{ getSettings('site_title') ?? 'eCom POS' }} - @yield('title')
    </title>
</head>

<body>
    <div id="app">
        @yield('content')
    </div>
    @vite('resources/js/app.js')
</body>

</html>
