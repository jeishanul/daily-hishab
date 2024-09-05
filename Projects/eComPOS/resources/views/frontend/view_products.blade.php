@extends('layouts.frontend')
@section('title', __('all_products'))
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
                                <img src="{{ asset('public/icons/menu.svg') }}" alt="menu" class="category-menu-icon">
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
            <div class="all-product-top-banner">
                <img src="{{ getSettings('all_products_banner_path') ? asset(getSettings('all_products_banner_path')) : asset('public/banners/top-banner.jpg') }}" alt="">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="best-sale-card">
                        <div class="best-sale">
                            {{ __('all_products') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4" id="all-products"></div>
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

    <input type="hidden" id="type" value="{{ $type ?? '' }}">
    <input type="hidden" id="slug" value="{{ $slug ?? '' }}">
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/frontend/js/home/categories-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/home/view-all-products.js') }}"></script>
@endpush
