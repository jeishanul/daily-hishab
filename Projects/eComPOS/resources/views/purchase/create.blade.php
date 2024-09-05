@extends('layouts.app')
@section('title', __('purchase_create'))
@section('content')
    <section class="forms">
        <form action="{{ route('purchase.store') }}" method="POST" id="purchase-form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header custom-card-header d-flex align-items-center card-header-color">
                            <span class="list-title text-white">{{ __('new_purchase') }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-select name="warehouse_id" title="warehouse" :required="true"
                                                placeholder="select_a_option">
                                                @foreach ($warehouses as $warehouse)
                                                    <option {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}
                                                        value="{{ $warehouse->id }}">
                                                        {{ $warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div class="col-md-6">
                                            <x-select name="supplier_id" title="supplier" :required="true"
                                                placeholder="select_a_option">
                                                @foreach ($suppliers as $supplier)
                                                    <option {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                                                        value="{{ $supplier->id }}">
                                                        {{ $supplier->name . ' (' . $supplier->personalInfo?->company_name . ')' }}
                                                    </option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-fileInputGroup name="document" title="attach_document" :required="false" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-inputGroup name="date" title="purchase_date" type="date"
                                                :required="false" placeholder="" value="{{ date('Y-m-d') }}" />
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="mb-2">{{ __('select_a_product') }}</label>
                                            <div class="search-box input-group">
                                                <span class="btn common-btn"><i class="fa fa-barcode"></i></span>
                                                <input type="text" name="product_code_name" id="searchProduct"
                                                    placeholder="{{ __('please_type_product_code_and_select') }}"
                                                    class="form-control rounded-end" />
                                                <div class="position-absolute w-100 products p-2 shadow" id="productList">
                                                </div>
                                            </div>
                                            @error('product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('name') }}</th>
                                                            <th>{{ __('code') }}</th>
                                                            <th>{{ __('quantity') }}</th>
                                                            <th>{{ __('batch') }}</th>
                                                            <th>{{ __('expired_date') }}</th>
                                                            <th>{{ __('purchase_cost') }}</th>
                                                            <th>{{ __('tax') }}</th>
                                                            <th>{{ __('sub_total') }}</th>
                                                            <th>{{ __('action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="purchaseProduct"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="total_tax" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <x-select name="order_tax_rate" :required="false" title="tax" id="payment-method"
                                            placeholder="select_a_option">
                                            @foreach ($taxs as $tax)
                                                <option {{ old('order_tax_rate') == $tax->rate ? 'selected' : '' }}
                                                    value="{{ $tax->rate }}">
                                                    {{ $tax->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <input type="hidden" name="tax_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2">{{ __('shipping_cost') }}</label>
                                        <input type="text" onkeypress="onlyNumber(event)" name="shipping_cost"
                                            class="form-control mb-2" step="any"
                                            placeholder="{{ __('enter_your_shipping_cost') }}" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2">{{ __('order_discount') }}</label>
                                        <input type="text" onkeypress="onlyNumber(event)" name="order_discount"
                                            class="form-control" step="any"
                                            placeholder="{{ __('enter_your_discount_amount') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <table class="table table-hover">
                                        <thead class="table-bg-color text-center">
                                            <tr>
                                                <th>{{ __('total_item') }}<br>
                                                    <p><span class="pull-right" data-purchase-product="0"
                                                            id="totalQtyProduct">(0)</span></p>
                                                    <input type="hidden" name="total_qty" />
                                                </th>
                                                <th>{{ __('total_product') }}<br>
                                                    <p><span class="pull-right" data-product="0"
                                                            id="totalProduct">0</span></p>
                                                    <input type="hidden" name="item" id="item" />
                                                </th>
                                                <th>{{ __('sub_total') }}<br>
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="subTotal">0.00</span>
                                                    <input type="hidden" name="total_cost" />
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">{{ __('order_tax') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="order_tax">0.00</span>
                                                </td>
                                                <input type="hidden" name="order_tax" />
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('order_discount') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="order_discount">0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('shipping_cost') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="shipping_cost">0.00</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="table-bg-color">
                                            <tr>
                                                <td colspan="2">{{ __('grand_total') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="grand_total">0.00</span>
                                                </td>
                                                <input type="hidden" name="grand_total" />
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <x-select name="payment_method" :required="false" title="{{ __('payment_method') }}"
                                        id="payment-method" placeholder="{{ __('select_a_option') }}">
                                        @foreach ($paymentMethods as $paymentMethod)
                                            <option value="{{ $paymentMethod->value }}">{{ $paymentMethod->value }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="mb-2" for="amount">{{ __('amount') }}</label>
                                        <input onkeypress="onlyNumber(event)" type="text" id="amount"
                                            class="form-control" placeholder="{{ __('enter_your_payable_amount') }}"
                                            name="paid_amount">
                                        @error('paid_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3" id="account-list"
                                    style="display: {{ old('payment_method') != 'Bank' ? 'none' : '' }}">
                                    <x-select name="account_id" :required="true" title="{{ __('bank_account') }}"
                                        placeholder="{{ __('select_a_option') }}">
                                        @foreach ($accounts as $account)
                                            <option {{ old('account_id') == $account->id ? 'selected' : '' }}
                                                value="{{ $account->id }}">
                                                {{ $account->name }} ({{ $account->account_no }})
                                            </option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('note') }}</label>
                                        <textarea name="note" id="summernote"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="row  mt-3">
                                        <div class="col-12 col-md-6">
                                            <button type="reset"
                                                class="btn mb-sm-2 reset-btn w-100">{{ __('reset') }}</button>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <button type="submit"
                                                class="btn common-btn w-100">{{ __('submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <style>
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
    </style>
@endsection
@push('scripts')
    <script src="{{ asset('public/assets/pages/purchase.js') }}"></script>
@endpush
