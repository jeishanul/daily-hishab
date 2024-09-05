@extends('layouts.app')

@section('title', __('product_barcode'))

@section('content')
    <style>
        /* Custom styles for the product barcode section */
        .product-item {
            background: #cccccc1c;
            border-radius: 8px;
            margin-bottom: 4px;
            cursor: pointer;
        }

        .products {
            background-color: #eef1f5 !important;
            max-height: 400px;
            z-index: 999;
            top: 40px;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            display: none;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        @media print {
            /* Print-specific styles */
            * {
                font-size: 12px;
                line-height: 20px;
            }

            td, th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                size: landscape;
                margin: 0 !important;
            }

            .barcodelist {
                max-width: 378px;
            }

            .barcodelist img {
                max-width: 150px;
            }
        }
    </style>

    <section class="forms">
        <div class="container-fluid">
            <!-- Form to generate barcode -->
            <form action="{{ route('product.barcode.generate') }}" method="post" target="_blank">
                @csrf
                <div class="row">
                    <!-- Left Section: Product Selection and List -->
                    <div class="col-lg-7 col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center card-header-color">
                                <span class="list-title text-white">{{ __('print_barcode') }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Product Search Input -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-2">{{ __('add_product') }}<span class="text-danger">*</span></label>
                                                <div class="search-box input-group">
                                                    <button type="button" class="btn common-btn btn-lg"><i class="fa fa-barcode"></i></button>
                                                    <input type="text" name="product_ids" id="searchProduct"
                                                           placeholder="{{ __('please_type_product_code_and_select') }}"
                                                           class="form-control" />
                                                    <div class="position-absolute w-100 products p-2 shadow" id="productList"></div>
                                                </div>
                                                @error('product_ids')
                                                    <span class="text-danger">{{ __('please_select_a_product') }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Product List Table -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive mt-3">
                                                    <table id="myTable" class="table table-hover order-list">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('name') }}</th>
                                                                <th>{{ __('code') }}</th>
                                                                <th>{{ __('quantity') }}</th>
                                                                <th>{{ __('action') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="productBarcode">
                                                            <!-- Dynamically added products will appear here -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Section: Barcode Options -->
                    <div class="col-lg-5 col-md-12">
                        <div class="card p-4">
                            <div class="row">
                                <!-- Barcode Display Options -->
                                <div class="col-md-12 mb-2">
                                    <div class="form-check">
                                        <input name="name" checked class="form-check-input" type="checkbox" id="name" value="1">
                                        <label class="form-check-label" for="name">{{ __('name') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-check">
                                        <input name="price" checked class="form-check-input" type="checkbox" id="price" value="1">
                                        <label class="form-check-label" for="price">{{ __('price') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <div class="form-check">
                                        <input name="promo_price" class="form-check-input" type="checkbox" id="promo_price" value="1">
                                        <label class="form-check-label" for="promo_price">{{ __('promotional_price') }}</label>
                                    </div>
                                </div>
                                <!-- Barcode Size Option -->
                                <div class="col-md-12 mb-2">
                                    <x-select name="size" title="size" :required="true" placeholder="select_a_option">
                                        <option value="row">{{ __('row') }}</option>
                                        <option value="single">{{ __('single') }}</option>
                                    </x-select>
                                </div>
                            </div>
                            <!-- Print Button -->
                            <div class="form-group mt-3">
                                <button type="submit" class="btn common-btn w-100">{{ __('print') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- Custom JS for Barcode Handling -->
    <script src="{{ asset('public/assets/pages/barcode.js') }}"></script>
@endpush
