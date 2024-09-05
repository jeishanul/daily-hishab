<!DOCTYPE html>
<html lang="en" class="{{ getSettings('dark_mode') == 1 ? 'dark' : 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png"
        href="{{ getSettings('small_logo_path') ? asset(getSettings('small_logo_path')) : asset('public/logo/small-logo.png') }}" />
    <title>
        {{ getSettings('site_title') ?? 'eCom POS' }} - {{ __('pos') }}
    </title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('public/assets/webfonts/poppins-medium.ttf') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/sweetalert2.min.css') }}" type="text/css">
    @vite('resources/css/app.css')
    
</head>
@include('sale.pos.components.style')

<body>
    <div class="min-h-screen bg-blue-50">
        <!-- header -->
        @include('sale.pos.components.header')
        <div class="py-[8px] px-4 bg-blue-50 print:hidden dark:bg-slate-500">
            <div class="grid gap-x-2 gap-y-5 xl:gap-y-0 grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 2xl:grid-cols-5">
                <!-- category and brand section -->
                @include('sale.pos.components.category_brand_section')
                <!-- Product -->
                @include('sale.pos.components.product_section')

                <!-- column three -->
                <div class="col-span-1 sm:col-span-3 lg:col-span-3 2xl:col-span-2">
                    <!-- customer section -->
                    @include('sale.pos.components.customer_section')
                    <!-- Cart and Calculate section -->
                    @include('sale.pos.components.cart_section')
                    <!-- Payment Method section -->
                    @include('sale.pos.components.payment_method_section')
                    <!-- process button section -->
                    @include('sale.pos.components.process_button_section')
                </div>

            </div>
        </div>
    </div>
    <!-- logout modal -->
    @include('sale.pos.components.logout_modal')
    <!-- Store Wallet Modal -->
    @include('sale.pos.components.store_wallet_modal')
    <!-- Customer Add Modal -->
    @include('sale.pos.components.customer_create_modal')
    <!-- Pos Script -->
    @include('sale.pos.script')
</body>

</html>
