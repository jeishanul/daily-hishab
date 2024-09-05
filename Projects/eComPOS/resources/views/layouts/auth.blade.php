<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <!-- Meta-Link -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="mlapplication-tap-highlight" content="no">
    <!-- FaveIcon-Link -->
    <link rel="icon" type="image/png"
        href="{{ getSettings('favicon_path') ? asset(getSettings('favicon_path')) : asset('public/logo/small-logo.png') }}" />
    <!-- Title -->
    <title>
        {{ getSettings('site_title') ?? 'eCom POS' }} - @yield('title')
    </title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('public/assets/webfonts/poppins-medium.ttf') }}">
    <!-- Bootstrap-Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}" type="text/css">
    <!-- Font-Awesome--Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">
    <!-- toastr css-->
    <link rel="stylesheet" href="{{ asset('public/assets/css/sweetalert2.min.css') }}" type="text/css">
    <!--Style--Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/login/assets/css/style.css') }}">
    <style>
        :root {
            --theme-color: {{ getSettings('primary_color') ?? '#29aae1' }};
            --theme-secondary-color: {{ getSettings('secondary_color') ?? '#eaf7fc' }};
            --bs-btn-bg: {{ getSettings('primary_color') ?? '#29aae1' }};
        }
    </style>
</head>

<body>
    <div class="w-100 d-flex flex-column gap-1" style="z-index: 99; position: fixed; top: 0;">
        @if ($seederRun)
            <div class="alert alert-danger alert-dismissible fade show mb-0 w-100 text-center rounded-0 text-black"
                role="alert" style="padding: 10px">
                <strong><i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="bottom"
                        title='If you do not run this seeder, you will not be able to use the system.'></i>
                    Seeder dose not run.</strong> Please run <code class="text-danger">php artisan migrate:fresh
                    --seed</code> or <a href="{{ route('seeder.run.index') }}" class="btn btn-sm common-btn"> Click
                    here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($storageLink)
            <div class="alert alert-danger alert-dismissible fade show mb-0 w-100 text-center rounded-0 text-black"
                role="alert" style="padding: 10px">
                <strong><i class="fa fa-exclamation-circle" data-toggle="tooltip" data-placement="bottom"
                        title='If you can not install storage link, then image not found.'></i>
                    Storage link dose not exist or image not found then</strong> please run <code
                    class="text-danger">php artisan
                    storage:link</code> or <a href="{{ route('storage.install.index') }}" class="btn btn-sm common-btn">
                    Click here</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Login-Section -->
    <section class="login-section">

        <div class="loginCard">
            @yield('content')
        </div>
    </section>
    <!--End-Login-Section -->
    <!-- Jquery-link -->
    <script src="{{ asset('public/assets/scripts/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/scripts/sweetalert_modify.js') }}"></script>
    <!-- Bootstrap-Min-Bundil-Link -->
    <script src="{{ asset('public/assets/scripts/bootstrap.bundle.min.js') }}"></script>
    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            })
        </script>
    @endif

    @stack('scripts')
</body>

</html>
