@extends('layouts.frontend')
@section('title', __('checkout'))
@section('content')
    <div class="row" style="margin-top: 100px !important; margin-bottom: 30px !important">
        <div class="col-md-6">
            <div class="card checkout-card">
                <div class="card-header checkout-card-header">Shipping Details</div>
                <div class="card-body">
                    <form method="post" id="address-form">
                        <input type="hidden" name="customer_id" id="customer_id" value="{{ Auth::user()->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="mb-2">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="name" id="name"
                                        value="{{ Auth::user()->name }}" placeholder="Enter Name" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="mb-2">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="phone_number"
                                        value="{{ Auth::user()->personalInfo?->phone }}" id="phone_number"
                                        placeholder="Enter Phone Number" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="email" class="mb-2">Email Address</label>
                                    <input type="text" class="form-control checkout-input" name="email" id="email"
                                        value="{{ Auth::user()->email }}" placeholder="Enter Email Address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="country" class="mb-2">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="country" id="country"
                                        value="{{ Auth::user()->personalInfo?->country }}" placeholder="Enter country"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="city" class="mb-2">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="city" id="city"
                                        value="{{ Auth::user()->personalInfo?->city }}" placeholder="Enter city" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="zip_code" class="mb-2">Zip / Post Code <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="zip_code" id="zip_code"
                                        value="{{ Auth::user()->personalInfo?->zip_code }}"
                                        placeholder="Enter Zip / Post Code" required>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group mb-3">
                                    <label for="address" class="mb-2">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control checkout-input" name="address" id="address"
                                        value="{{ Auth::user()->personalInfo?->address }}" placeholder="Enter Address"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn address-btn">Save Address</button>
                            </div>
                            {{-- <div class="col-md-12">
                                <div>Other Address</div>
                            </div>
                            <div class="col-md-12">
                                <div class="address-details">
                                    <div class="address-name">Sekhertek, 52/A, Adabor, Mohammadpur-1207</div>
                                    <div class="address-edit">
                                        <i class="fa fa-pencil-alt address-edit-icon"></i>
                                        <input type="checkbox" name="is_default" class="address-edit-checkbox" checked>
                                    </div>
                                </div>
                                <div class="address-details">
                                    <div class="address-name">Sekhertek, 52/A, Adabor, Mohammadpur-1207</div>
                                    <div class="address-edit">
                                        <i class="fa fa-pencil-alt address-edit-icon"></i>
                                        <input type="checkbox" name="is_default" class="address-edit-checkbox">
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card checkout-card">
                <div class="card-header checkout-card-header">Payment Details</div>
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table-checkout">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add-to-cart-product"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control checkout-input" name="coupon"
                                        id="coupon" placeholder="Apply Coupon" required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn remove-btn">Remove</button>
                                <button type="button" class="btn apply-btn d-none">Apply</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="add-to-cart-calculate-section">
                                    <span>Subtotal</span>
                                    <span id="subtotal">0.00</span>
                                </div>
                                <div class="add-to-cart-calculate-section">
                                    <input type="hidden" name="coupon_id" id="coupon_id">
                                    <span>Coupon Discount</span>
                                    <span id="couponDiscount">0.00</span>
                                </div>
                                {{-- <div class="add-to-cart-calculate-section">
                                    <span>Delivery Charge</span>
                                    <span>$100.00</span>
                                </div> --}}
                                <div class="add-to-cart-calculate-section border">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold" id="total" data-total="">0.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn checkout-btn">Place Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <td>
        <div class="add-to-cart-product-quantity">
            <img src="{{ asset('public/icons/web-minus.svg') }}" alt="">
            <div>${product.qty}</div>
            <img src="{{ asset('public/icons/web-plus.svg') }}" alt="">
        </div>
    </td> --}}
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/frontend/js/checkout/checkout.js') }}"></script>
@endpush
