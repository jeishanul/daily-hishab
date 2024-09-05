@extends('layouts.frontend')
@section('title', __('profile'))
@section('content')
    <div class="row" style="margin-top: 100px !important; margin-bottom: 65px !important">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('store'))
                                    <a class="nav-link d-flex gap-2 align-items-center nav-tab-update-btn"
                                        href="{{ route('root') }}"><img src="{{ asset('public/icons/menu.svg') }}"
                                            alt="icon" class="nav-tab-icon">{{ __('dashboard') }}
                                    </a>
                                @endif
                                <button
                                    class="nav-link d-flex gap-2 align-items-center nav-tab-update-btn {{ request()->type == 'profile' ? 'active' : '' }}"
                                    id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                                    type="button" role="tab" aria-controls="v-pills-profile"
                                    aria-selected="{{ request()->type == 'profile' ? 'true' : 'false' }}">
                                    <img src="{{ asset('public/icons/user-polygon.svg') }}" alt="icon"
                                        class="nav-tab-icon">
                                    {{ __('profile') }}
                                </button>

                                <button
                                    class="nav-link d-flex gap-2 align-items-center nav-tab-update-btn {{ request()->type == 'order' ? 'active' : '' }}"
                                    id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders"
                                    type="button" role="tab" aria-controls="v-pills-orders"
                                    aria-selected="{{ request()->type == 'order' ? 'true' : 'false' }}">
                                    <img src="{{ asset('public/icons/shopping-cart.svg') }}" alt="icon"
                                        class="nav-tab-icon">
                                    {{ __('orders') }}
                                </button>
                                {{-- <button class="nav-link d-flex gap-2 align-items-center nav-tab-update-btn"
                                    id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages"
                                    type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                    <img src="{{ asset('public/icons/shop.svg') }}" alt="icon" class="nav-tab-icon">
                                    Manage Addresses
                                </button> --}}
                                <a href="{{ route('user.signout') }}"
                                    class="nav-link d-flex gap-2 align-items-center nav-tab-update-btn">
                                    <img src="{{ asset('public/icons/logout.svg') }}" alt="icon" class="nav-tab-icon">
                                    {{ __('logout') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade {{ request()->type == 'profile' ? 'show active' : '' }}"
                                    id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="nav-tab-heading">
                                        My Personal Info
                                    </div>
                                    <div class="nav-tab-main-section">
                                        <form action="">
                                            @csrf
                                            @method('PUT')
                                            @include('frontend.profile_form')
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ request()->type == 'order' ? 'show active' : '' }}"
                                    id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                                    <div class="nav-tab-heading">
                                        {{ __('orders_history') }}
                                    </div>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active nav-tab-update-btn" id="pills-pending-orders-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-pending-orders" type="button"
                                                role="tab" aria-controls="pills-pending-orders" aria-selected="true">
                                                {{ __('pending') }}
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-tab-update-btn" id="pills-on-process-orders-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-on-process-orders"
                                                type="button" role="tab" aria-controls="pills-on-process-orders"
                                                aria-selected="false">
                                                {{ __('on_process') }}
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-tab-update-btn" id="pills-delivered-orders-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-delivered-orders"
                                                type="button" role="tab" aria-controls="pills-delivered-orders"
                                                aria-selected="false">
                                                {{ __('delivered') }}
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-tab-update-btn" id="pills-canceled-orders-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-canceled-orders" type="button"
                                                role="tab" aria-controls="pills-canceled-orders" aria-selected="false">
                                                {{ __('canceled') }}
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link nav-tab-update-btn" id="pills-all-orders-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-all-orders" type="button"
                                                role="tab" aria-controls="pills-all-orders" aria-selected="false">
                                                {{ __('all_orders') }}
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        @include('frontend.orders')
                                    </div>
                                </div>
                                {{-- <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="nav-tab-heading d-flex justify-content-between">
                                        <div>My Address</div>
                                        <button class="btn btn-info add-new-address" data-bs-toggle="modal"
                                            data-bs-target="#addNewAddressModal">Add new Address</button>
                                    </div>
                                    <div class="nav-tab-main-section">
                                        @include('frontend.address_manage')
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNewAddressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addNewAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewAddressModalLabel">Add new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" id="address" class="form-control"
                            placeholder="Enter Address" aria-describedby="helpId" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary w-100 add-new-address">Save Address</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/frontend/js/order/my-orders-fetch.js') }}"></script>
    @if (request()->type == 'order')
        <script>
            Swal.fire({
                title: "Order Successfully Placed!",
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Confirm",
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/';
                }
            });
        </script>
    @endif

    <script src="{{ asset('public/assets/frontend/js/profile/profile-update.js') }}"></script>
@endpush
