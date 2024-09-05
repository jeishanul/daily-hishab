<div class="app-header header-shadow">
    <div class="app-header-logo"></div>
    <div class="app-header-mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header-menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn common-btn btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header-content">
        <!-- Header-left-Section -->
        <div class="app-header-left">
            <div class="header-pane ">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                        data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <!-- End-Header-Left-section -->

        <!-- Header-Rignt-Section -->
        <div class="app-header-right">
            <div class="badgeButtonBox">
                <div class="notifactionIcon  me-4">
                    <a href="{{ route('sale.pos') }}" class="btn common-btn mr-3 d-block">
                        <i class="fa-solid fa-cart-plus"></i> {{ __('pos') }}
                    </a>
                </div>
            </div>
            <div class="badgeButtonBox">
                @if (getSettings('dark_mode') == 0)
                    <a href="{{ route('theme.update', 1) }}" class="theme-change-btn">
                        <img src="{{ asset('public/icons/light.svg') }}" alt="">
                    </a>
                @else
                    <a href="{{ route('theme.update', 0) }}" class="theme-change-btn">
                        <img src="{{ asset('public/icons/dark.svg') }}" alt="">
                    </a>
                @endif
            </div>
            @php
                use App\Models\Language;
                $languages = Language::All();
                $language = Language::where('name', app()->getLocale())->first();
            @endphp
            <div class="user-profile-box dropdown mx-3">
                <div class="nav-profile-box dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-image language-image d-flex gap-2">
                        <a href="#">
                            <img class="" src="{{ $language->media->file }}" alt="{{ $language->title }}">
                        </a>
                        <div>{{ $language->title }}</div>
                    </div>
                </div>
                <div class="dropdown-menu profile-item">
                    @foreach ($languages as $lang)
                        <a href="{{ route('change.local', 'ln=' . $lang->name) }}" class="dropdown-item">
                            <img src="{{ $lang->media->file }}" alt="{{ $lang->title }}" width="20"
                                class="me-2"> {{ $lang->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="user-profile-box dropdown ml-3">
                <div class="nav-profile-box dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-image">
                        <a href=""><img class="profilepic"
                                src="{{ auth()->user()->media->file ?? asset('public/default/default.jpg') }}"
                                alt=""></a>
                    </div>
                    <div class="profile-content">
                        <span>{{ ucfirst(auth()->user()->name) }}</span>
                        <i class="fa-solid fa-angle-down dropIcon"></i>
                    </div>
                </div>

                <div class="dropdown-menu profile-item">
                    <a href="{{ route('profile.index', auth()->id()) }}" class="dropdown-item"><i
                            class="fa fa-user me-2"></i>{{ __('profile') }}</a>
                    <a href="{{ route('settings.index') }}" class="dropdown-item"><i
                            class="fa fa-cog me-2"></i>{{ __('settings') }}</a>
                    <a href="{{ route('profile.index', auth()->id()) }}" class="dropdown-item"><i
                            class="fa-solid fa-key me-2"></i>{{ __('change_password') }}</a>

                    <a href="#" onclick="signout()" class="dropdown-item cursor-pointer"><i
                            class="fa-solid fa-right-from-bracket me-2"></i>{{ __('logout') }}</a>
                </div>
            </div>
        </div>
        <!-- End-Header-Right-Section -->

    </div>
</div>
