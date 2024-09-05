@extends('layouts.auth')
@section('title', __('signup'))
@section('content')
    <form action="{{ route('signup.request') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <a href="{{ route('home') }}" class="logo-img">
            <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/logo.png') }}" alt="">
        </a>
        <div class="page-content">
            <h2 class="pageTitle">{{ __('welcome_to') }}
                <span>
                    {{ getSettings('site_title') ?? 'eCom POS' }}
                </span>
            </h2>
            <h1 class="signin-heading">{{ __('sign_up') }}</h1>
        </div>
        <div class="form-outline form-white mb-2 mb-md-3">
            <label class="mb-2" for="name">{{ __('enter_your_name') }}</label>
            <input type="text" name="name" id="name" class="form-control mb-1" value="{{ old('name') }}" placeholder="{{ __('name') }}">
            @error('name')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-outline form-white mb-2 mb-md-3">
            <label class="mb-2" for="email">{{ __('enter_your_email') }}</label>
            <input type="email" name="email" id="email" class="form-control mb-1" value="{{ old('email') }}" placeholder="{{ __('email') }}">
            @error('email')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-outline form-white mb-2 mb-md-3">
            <label class="mb-2">{{ __('enter_your_assword') }}</label>
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
        <div class="form-outline form-white mb-2 mb-md-3">
            <label class="mb-2">{{ __('enter_your_confirm_assword') }}</label>
            <div class="position-relative">
                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control mb-1"
                    placeholder="{{ __('confirm_password') }}">
                <span class="eye" onclick="showHideConfirmPassword()">
                    <i class="far fa-eye fa-eye-slash" id="toggleConfirmPassword"></i>
                </span>
            </div>
            @error('password')
                <span class="text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button class="btn loginButton" type="submit">{{ __('sign_up') }}</button>
        <span class="text-center w-100 d-block pt-2 mt-4">{{ __('already_have_a_account') }} <a
                href="{{ route('signin') }}" class="signup-link">{{ __('signin') }}</a></span>
    </form>
@endsection
@push('scripts')
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

        function showHideConfirmPassword() {
            const toggle = document.getElementById("toggleConfirmPassword");
            const password = document.getElementById("confirmPassword");

            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            toggle.classList.toggle("fa-eye");
        }
    </script>
@endpush
