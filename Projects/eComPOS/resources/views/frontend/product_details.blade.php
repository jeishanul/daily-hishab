@extends('layouts.frontend')
@section('title', __('product_details'))
@section('content')
    <div class="cart-box" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <div class="cart-box-text cart-counter">0</div>
        <img src="{{ asset('public/icons/web-shopping-cart.svg') }}" alt="cart" class="cart-box-image">
    </div>
    <div class="row" style="margin-top: 100px !important">
        <div class="col-md-3 col-sm-1">
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

        <div class="col-md-9 col-sm-11">
            <div class="row">
                <div class="col-md-7">
                    <div class="product-details-image">
                        <img src="" alt="product" class="product-details-image-main">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="product-details-title"></div>
                    <div class="product-details-rating-section">
                        <div class="product-details-rating-container">
                            <img src="{{ asset('public/icons/star.svg') }}" alt="star"
                                class="product-details-rating-image">
                            <div class="product-details-rating">0</div>
                            <div class="product-details-rating-count">(0)</div>
                        </div>
                        <div class="product-details-in-stock"></div>
                    </div>
                    <div class="product-details-price-section">
                        <div class="d-flex gap-2 align-items-end">
                            <div class="product-details-old-price"></div>
                            <div class="product-details-price"></div>
                        </div>
                        <div class="product-details-wishlist wishlist-add-request" data-id="">
                            <img src="{{ asset('public/icons/heart.svg') }}" alt="wishlist">
                        </div>
                    </div>
                    <div class="product-details-add-to-cart-section">
                        <div class="product-details-quantity-section">
                            <img src="{{ asset('public/icons/web-minus.svg') }}" alt="minus"
                                class="product-details-minus-button" data-id="">
                            <div class="product-details-quantity" id="">1</div>
                            <img src="{{ asset('public/icons/web-plus.svg') }}" alt="plus"
                                class="product-details-plus-button" data-id="">
                        </div>
                        <div class="product-details-add-to-cart">
                            <a href="javascript:void(0)" class="product-details-checkout-button add-to-cart-request"
                                data-id="">
                                <img src="{{ asset('public/icons/web-shopping-cart.svg') }}" alt="cart">
                                {{ __('add_to_cart') }}
                            </a>
                        </div>
                    </div>
                    <div class="product-details-images" id="product-details-image-swiper"></div>
                </div>
                <div class="col-md-12">
                    <div class="product-details-description"></div>
                </div>
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
    </div>
    <input type="hidden" id="slug" value="{{ $slug ?? '' }}">
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/frontend/js/home/categories-fetch.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/product/product-details-fetch.js') }}"></script>
    <script>
        $(document).on("click", ".product-details-image", function () {
            var src = $(this).attr("src");
            $(".product-details-image-main").attr("src", src);
        });
    </script>
@endpush
