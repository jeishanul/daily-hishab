@extends('layouts.frontend')
@section('title', __('home'))
@section('content')
    <div class="cart-box" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <div class="cart-box-text cart-counter">0</div>
        <img src="{{ asset('public/icons/web-shopping-cart.svg') }}" alt="cart" class="cart-box-image">
    </div>

    <div class="row" style="margin-top: 100px !important">
        <div class="col-md-3">
            <div class="card custom-card category-section">
                <div class="accordion" id="categorySection">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button gap-2 category-menu" type="button" data-bs-toggle="collapse"
                                data-bs-target="#categorySectionMenu" aria-expanded="true"
                                aria-controls="categorySectionMenu">
                                <img src="{{ asset('public/icons/menu.svg') }}" alt="menu" class="category-menu-icon header-icon">
                                {{ __('categories') }}
                            </button>
                        </h2>
                        <div id="categorySectionMenu" class="accordion-collapse collapse show"
                            data-bs-parent="#categorySection">
                            <div class="accordion accordion-flush" id="categorySectionSubmenu"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <!-- Slider main container -->
                        <div class="swiper mainBanner">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper"></div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-4">
                    <div class="info-section">
                        <div class="info-details">
                            <img src="{{ asset('public/icons/moving-home.svg') }}" alt="">
                        </div>
                        <span class="info-title info-moving-home-color">{{ __('home_delivery') }}</span>
                        <p class="info-text">
                            {{ getSettings('home_delivery_description') ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-section">
                        <div class="info-details">
                            <img src="{{ asset('public/icons/secure-payment.svg') }}" alt="">
                        </div>
                        <span class="info-title info-secure-payment-color">{{ __('secure_payment') }}</span>
                        <p class="info-text">
                            {{ getSettings('payment_security_description') ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-section">
                        <div class="info-details">
                            <img src="{{ asset('public/icons/support.svg') }}" alt="">
                        </div>
                        <span class="info-title info-support-color">{{ __('support') }}</span>
                        <p class="info-text">
                            {{ getSettings('support_description') ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="best-sale-card">
                        <div class="best-sale">
                            {{ __('big_sale') }}
                        </div>
                        <a href="{{ route('view.all.products', ['type' => 'big-sale', 'slug' => 'all']) }}"
                            class="best-sale-text">
                            {{ __('view_all') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row my-4" id="big-sale-products"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="best-sale-card-image">
                        <img src="{{ getSettings('big_sale_banner_path') ? asset(getSettings('big_sale_banner_path')) : asset('public/banners/big_sale.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="best-sale-card">
                        <div class="best-sale">
                            {{ __('best_deal') }}
                        </div>
                        <a href="{{ route('view.all.products', ['type' => 'best-deal', 'slug' => 'all']) }}"
                            class="best-sale-text">
                            {{ __('view_all') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row my-4" id="best-deal-products"></div>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="best-sale-card">
                        <div class="best-sale">
                            {{ __('customer_choice') }}
                        </div>
                        <a href="{{ route('view.all.products', ['type' => 'customer-choice', 'slug' => 'all']) }}"
                            class="best-sale-text">
                            {{ __('view_all') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row my-4" id="customer-choice-products"></div>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="best-sale-card">
                        <div class="best-sale">
                            {{ __('new_products') }}
                        </div>
                        <a href="{{ route('view.all.products', ['type' => 'new-products', 'slug' => 'all']) }}"
                            class="best-sale-text">
                            {{ __('view_all') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row my-4" id="new-products"></div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">{{ __('my_cart_products') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <ul class="cart-product-ul cart-products"></ul>
        @if (Auth::check())
            <div class="cart-footer">
                <a href="{{ route('checkout') }}" class="checkout-button">{{ __('proceed_to_checkout') }}</a>
            </div>
        @endif
    </div>
    <style>
        .swiper {
            width: 100%;
            height: auto;
        }
    </style>

@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('public/assets/frontend/js/home/categories-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/new-products-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/customer-choice-products-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/banner-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/big-sale-products-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/best-deal-products-fetch.js') }}"></script>
@endpush
