@extends('layouts.auth')
@section('title', __('signin'))
@section('content')
    <style>
        .version-text {
            position: absolute;
            right: 10px;
            font-size: 15px;
            top: 10px;
            font-weight: 600;
            color: #3bb2fb;
            padding: 0 5px;
            background-color: #3bb2fb36;
            margin-right: 15px;
            border-radius: 5px;
        }
    </style>
    <form action="{{ route('signin.request') }}" method="POST">
        @csrf
        <a href="{{ route('home') }}" class="logo-img">
            <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/logo.png') }}"
                alt="">
        </a>
        <div class="page-content">
            <h2 class="pageTitle">{{ __('welcome_to') }} <span>{{ getSettings('site_title') ?? 'eCom POS' }}</span>
            </h2>
            <h1 class="signin-heading">{{ __('sign_in') }}</h1>
        </div>

        <div class="form-outline form-white mb-3">
            <label class="mb-2">{{ __('enter_your_email') }} <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control mb-1" placeholder="{{ __('email') }}">
            @error('email')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-outline form-white mb-3">
            <label class="mb-2">{{ __('enter_your_assword') }} <span class="text-danger">*</span></label>
            <div class="position-relative">
                <input type="password" id="password" name="password" class="form-control mb-1"
                    placeholder="{{ __('password') }}">
                <span class="eye" onclick="showHidePassword()">
                    <i class="far fa-eye fa-eye-slash" id="togglePassword"></i>
                </span>
            </div>
            @error('password')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button class="btn loginButton" type="submit">{{ __('sign_in') }}</button>
        <span class="text-center w-100 d-block pt-2 mt-4">{{ __('register_yourself_as_a_new_user') }} <a
                href="{{ route('signup') }}" class="signup-link">{{ __('signup') }}</a></span>
        @if (config('app.env') == 'local')
            <div class="w-100 d-flex justify-content-between pt-2 mt-4 align-items-center copy-content">
                <div>
                    <div class="d-flex gap-2 mb-2">
                        <div class="fw-bold">Email:</div>
                        <div>admin@example.com</div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="fw-bold">Password:</div>
                        <div>secret</div>
                    </div>
                </div>
                <div>
                    <button type="button" id="admin" class="btn copy-button">{{ __('copy') }}</button>
                </div>
            </div>

            <div class="w-100 d-flex justify-content-between pt-2 mt-4 align-items-center copy-content">
                <div>
                    <div class="d-flex gap-2 mb-2">
                        <div class="fw-bold">Email:</div>
                        <div>customer@example.com</div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="fw-bold">Password:</div>
                        <div>secret</div>
                    </div>
                </div>
                <div>
                    <button type="button" id="customer" class="btn copy-button">{{ __('copy') }}</button>
                </div>
            </div>
        @endif
    </form>
@endsection
@push('scripts')
    <script>
        $('#admin').on('click', function() {
            $('#email').val('admin@example.com');
            $('#password').val('secret');
        });
        $('#customer').on('click', function() {
            $('#email').val('customer@example.com');
            $('#password').val('secret');
        });
    </script>

    <script>
        function showHidePassword() {
            const toggle = document.getElementById("togglePassword");
            const password = document.getElementById("password");

            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            toggle.classList.toggle("fa-eye");
        }
    </script>
@endpush
