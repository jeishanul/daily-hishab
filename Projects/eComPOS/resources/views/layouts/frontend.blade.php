<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Style--Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/assets/frontend/css/style.css') }}">
    <!--Bootstrap-Css -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}" type="text/css">
    <!--Font-Awesome-Icon-Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">
    <!--Font-Awesome-Icon-Css-Link -->
    <link rel="stylesheet" href="{{ asset('public/assets/webfonts/poppins-medium.ttf') }}">
    <!--Favicon-->
    <link rel="shortcut icon" href="{{ asset('public/logo/small-logo.png') }}" type="image/x-icon">
    <!--Swiper-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!--Title-->
    <title>{{ getSettings('site_title') ?? 'eCom POS' }} - @yield('title')</title>
    <style>
        :root {
            --theme-color: {{ getSettings('primary_color') ?? '#29aae1' }};
            --theme-secondary-color: {{ getSettings('secondary_color') ?? '#eaf7fc' }};
            --bs-btn-bg: {{ getSettings('primary_color') ?? '#29aae1' }};
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-section fixed-top">
            <div class="container mx-auto">
                <a class="navbar-brand navbar-logo" href="{{ route('home') }}">
                    <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/logo.png') }}"
                        alt="logo" class="logo">
                    <img src="{{ getSettings('small_logo_path') ? asset(getSettings('small_logo_path')) : asset('public/logo/small-logo.png') }}"
                        alt="logo" class="logo-small">
                </a>
                <form method="get" class="d-flex search-form">
                    <input type="text" class="navbar-search" name="search" id="search"
                        placeholder="{{ __('search') }}">
                    <button type="button" class="btn-navbar-search" id="search-btn"><i
                            class="fa fa-search"></i></button>
                </form>
                <div>
                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item nav-item-icon" data-bs-toggle="offcanvas"
                            data-bs-target="#wishlistoffcanvasRight" aria-controls="wishlistoffcanvasRight">
                            <a href="javascript:void(0)" class="nav-link nav-link-icon">
                                <i class="fa fa-heart"></i>
                                <span class="counter wishlist-counter">0</span>
                            </a>
                        </li>
                        <li class="nav-item nav-item-icon" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                            aria-controls="offcanvasRight">
                            <a href="javascript:void(0)" class="nav-link nav-link-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="counter cart-counter">0</span>
                            </a>
                        </li>
                        @if (Auth::check())
                            <li class="nav-item nav-item-icon">
                                <a href="{{ route('profile', ['type' => 'profile']) }}"
                                    class="nav-link nav-link-icon nav-link-icon-profile">
                                    <img src="{{ asset(Auth::user()->media->file ?? asset('public/default/default.jpg')) }}"
                                        alt="">
                                </a>
                            </li>
                        @else
                            <li class="nav-item nav-item-icon nav-item-user">
                                <a href="{{ route('signin') }}" class="nav-link nav-link-icon">
                                    <i class="fa fa-user"></i>
                                </a>
                            </li>
                            <li class="nav-item nav-item-login">
                                <a href="{{ route('signin') }}"
                                    class="nav-link nav-link-login">{{ __('login') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    <footer class="footer">
        <div class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="footer-logo">
                                    <img src="{{ getSettings('dark_logo_path') ? asset(getSettings('dark_logo_path')) : asset('public/logo/dark-logo.png') }}"
                                        alt="logo">
                                </div>
                                <p class="footer-text">
                                    {{ getSettings('about_us') ?? 'We provide best POS solution. We provide best POS solution. We provide best POS solution. We provide best POS solution. We provide best POS solution. We provide best POS solution.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <ul class="footer-menu">
                            <li class="footer-menu-title">
                                <div class="footer-menu-title-text">{{ __('contact_information') }}</div>
                            </li>
                            <li class="footer-menu-title">
                                <a href="phone:{{ getSettings('phone') ?? '+8801714231625' }}"
                                    class="footer-menu-link">
                                    <i class="fa fa-phone"></i>
                                    {{ getSettings('phone') ?? '+8801714231625' }}
                                </a>
                            </li>
                            <li class="footer-menu-title">
                                <a href="mailto:{{ getSettings('email') ?? 'support@razinsoft.com' }}}"
                                    class="footer-menu-link">
                                    <i class="fa fa-envelope"></i>
                                    {{ getSettings('email') ?? 'support@razinsoft.com' }}
                                </a>
                            </li>
                            <li class="footer-menu-title">
                                <a href="#" class="footer-menu-link">
                                    <i class="fa fa-map-marker"></i>
                                    {{ getSettings('address') ?? 'Dhaka, Bangladesh' }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="footer-menu">
                            <li class="footer-menu-title">
                                <div class="footer-menu-title-text">{{ __('quick_links') }}</div>
                            </li>
                            <li class="footer-menu-title">
                                <a href="javascript:void(0)" class="footer-menu-link">{{ __('about_us') }}</a>
                            </li>
                            <li class="footer-menu-title">
                                <a href="javascript:void(0)" class="footer-menu-link">{{ __('contact_us') }}</a>
                            </li>
                            <li class="footer-menu-title">
                                <a href="javascript:void(0)"
                                    class="footer-menu-link">{{ __('terms_and_condition') }}</a>
                            </li>
                            <li class="footer-menu-title">
                                <a href="javascript:void(0)" class="footer-menu-link">{{ __('privacy_policy') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="footer-copyright">
                            <p class="footer-copyright-text">
                                © {{ getSettings('copyright_text') ?? 'Copyright 2022. All Rights Reserved by' }}
                                <a href="{{ getSettings('copyright_url') ?? 'https://www.razinsoft.com' }}"
                                    target="_blank">{{ getSettings('developed_by') ?? 'eCom POS' }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </footer>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="wishlistoffcanvasRight"
        aria-labelledby="wishlistoffcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="wishlistoffcanvasRightLabel">{{ __('my_wish_list') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <ul class="cart-product-ul wishlist-products"></ul>
    </div>
</body>
<!-- jquery-3.6.3.min.js` link -->
<script src="{{ asset('public/assets/scripts/jquery-3.6.3.min.js') }}"></script>
<!-- Bootstrap-Min-Bundil-Link -->
<script src="{{ asset('public/assets/scripts/bootstrap.bundle.min.js') }}"></script>
<!-- Search Products -->
<script src="{{ asset('public/assets/frontend/js/home/search-products-fetch.js') }}"></script>
<!-- SWEETALERT -->
<script src="{{ asset('public/assets/scripts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/scripts/sweetalert_modify.js') }}"></script>
<!-- Wishlist Add Request -->
<script src="{{ asset('public/assets/frontend/js/home/wishlist-add-request.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('public/assets/frontend/js/home/main.js') }}"></script>
<!-- scripts -->
@stack('scripts')
<!-- Toast Notifications -->
@if (session('success') || session('error') || session('errors'))
    @php
        $messages = [];
        if (session('success')) {
            $messages[] = [
                'type' => 'success',
                'message' => session('success'),
            ];
        }
        if (session('error')) {
            $messages[] = [
                'type' => 'error',
                'message' => session('error'),
            ];
        }
        if (session('errors')) {
            foreach (session('errors')->all() as $error) {
                $messages[] = [
                    'type' => 'error',
                    'message' => $error,
                ];
            }
        }
    @endphp
    <script>
        $(document).ready(function() {
            @foreach ($messages as $message)
                Toast.fire({
                    icon: '{{ $message['type'] }}',
                    title: "{{ $message['message'] }}"
                });
            @endforeach
        });
    </script>
@endif
<script>
    function currencySymbol(number) {
        var symbol = currency_symbol() ?? '$';

        if (currency_position() === "Prefix") {
            return symbol + ' ' + Number(number).toFixed(2);
        }

        return Number(number).toFixed(2) + ' ' + symbol;
    }

    function currency_symbol() {
        return {!! json_encode(getSettings('currency_symbol')) !!};
    }

    function currency_position() {
        return {!! json_encode(getSettings('currency_position')) !!};
    }
</script>

</html>
