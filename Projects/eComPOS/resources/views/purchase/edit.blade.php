@extends('layouts.app')
@section('title', __('purchase_edit'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <form action="{{ route('purchase.update', $purchase->id) }}" method="POST" id="purchase-form"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header custom-card-header d-flex align-items-center card-header-color">
                                <span class="list-title text-white">{{ __('purchase_edit') }}
                                    #{{ $purchase->reference_no }}</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6  mb-3">
                                                <x-select name="warehouse_id" title="{{ __('warehouse') }}"
                                                    placeholder="{{ __('select_a_option') }}">
                                                    @foreach ($warehouses as $warehouse)
                                                        <option
                                                            {{ $warehouse->id == $purchase->warehouse_id ? 'selected' : '' }}
                                                            value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div class="col-md-6  mb-3">
                                                <x-select name="supplier_id" title="{{ __('supplier') }}" placeholder="{{ __('select_a_option') }}">
                                                    @foreach ($suppliers as $supplier)
                                                        <option
                                                            {{ $supplier->id == $purchase->supplier_id ? 'selected' : '' }}
                                                            value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-input name="document" title="{{ __('attach_document') }}" type="file"
                                                    :required="false" />
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn common-btn w-100" data-toggle="modal"
                                                    data-target="#attachDocumentModal"
                                                    style="margin-top:31px">{{ __('preview') }}</button>
                                            </div>
                                            <div class="col-md-6">
                                                <x-input name="date" title="{{ __('select_a_product') }}" type="date"
                                                    value="{{ $purchase->date }}" :required="false"
                                                    placeholder="{{ __('purchase_date') }}" />
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <label class="mb-2">{{ __('select_a_product') }}</label>
                                                <div class="search-box input-group">
                                                    <button class="btn common-btn"><i class="fa fa-barcode"></i></button>
                                                    <input type="text" name="product_code_name" id="searchProduct"
                                                        placeholder="{{ __('please_type_product_code_and_select') }}"
                                                        class="form-control" />
                                                    <div class="position-absolute w-100 products p-2 shadow"
                                                        id="productList">
                                                    </div>
                                                </div>
                                                @error('product_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
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
                                                        <tbody id="purchaseProduct">
                                                            @foreach ($purchase->purchaseProducts as $productPurchase)
                                                                <tr class="productPurchaseRow"
                                                                    id="productPurchaseRow_{{ $productPurchase->product->id }}"
                                                                    data-id="{{ $productPurchase->product->id }}">
                                                                    <input type="hidden"
                                                                        name="products[{{ $productPurchase->product->id }}][id]"
                                                                        value="{{ $productPurchase->product->id }}">
                                                                    <td>{{ substr($productPurchase->product->name, 0, 20) }}
                                                                    </td>
                                                                    <td>{{ $productPurchase->product->code }}</td>
                                                                    <td>
                                                                        <input type="number" class="form-control qty"
                                                                            name="products[{{ $productPurchase->product->id }}][qty]"
                                                                            id="productQty_{{ $productPurchase->product->id }}"
                                                                            onchange="countQty()"
                                                                            value="{{ $productPurchase->qty }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            name="products[{{ $productPurchase->product->id }}][batch]"
                                                                            value="{{ $purchase->purchaseBatches()->where('product_id', $productPurchase->product->id)->first()->name ?? '' }}"
                                                                            {{ $productPurchase->product->is_batch ? '' : 'disabled' }}>
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" class="form-control"
                                                                            name="products[{{ $productPurchase->product->id }}][expire_date]"
                                                                            value="{{ $purchase->purchaseBatches()->where('product_id', $productPurchase->product->id)->first()->expire_date ?? '' }}"
                                                                            {{ $productPurchase->product->is_batch ? '' : 'disabled' }}>
                                                                    </td>
                                                                    <td class="net_unit_cost">
                                                                        {{ $productPurchase->product->price }}</td>
                                                                    <input type="hidden"
                                                                        name="products[{{ $productPurchase->product->id }}][netUnitCost]"
                                                                        value="{{ $productPurchase->product->price }}">
                                                                    <td class="tax">{{ $productPurchase->tax }}</td>
                                                                    <input type="hidden"
                                                                        name="products[{{ $productPurchase->product->id }}][tax]"
                                                                        id="tax" value="{{ $productPurchase->tax }}">

                                                                    <td class="sub-total">{{ $productPurchase->total }}
                                                                    </td>
                                                                    <input type="hidden"
                                                                        name="products[{{ $productPurchase->product->id }}][subTotal]"
                                                                        class="subTotal"
                                                                        value="{{ $productPurchase->total }}">
                                                                    <td class="d-flex">
                                                                        <button style="font-size:20px" type="button"
                                                                            class="btn text-danger"
                                                                            onclick='deleteRow("{{ $productPurchase->product->id }}")'><i
                                                                                class="fa fa-times"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_discount"
                                                        value="{{ $purchase->total_discount }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_tax"
                                                        value="{{ $purchase->total_tax }}" />
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
                                            <x-select name="order_tax_rate" :required="false" title="{{ __('tax') }}"
                                                id="payment-method" placeholder="{{ __('select_a_option') }}">
                                                @foreach ($taxs as $tax)
                                                    <option dataId="{{ $tax->id }}"
                                                        {{ isset($purchase->tax_id) && $purchase->tax_id == $tax->id ? 'selected' : '' }}
                                                        value="{{ $tax->rate }}">{{ $tax->name }}
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
                                                value="{{ $purchase->shipping_cost }}" class="form-control mb-2"
                                                step="any" placeholder="{{ __('enter_your_shipping_cost') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2">{{ __('order_discount') }}</label>
                                            <input type="text" onkeypress="onlyNumber(event)" name="order_discount"
                                                value="{{ $purchase->order_discount }}" class="form-control"
                                                step="any" placeholder="{{ __('enter_your_discount_amount') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <table class="table table-hover">
                                        <thead class="table-bg-color text-center">
                                            <tr>
                                                <th>{{ __('total_item') }}<br>
                                                    <p><span class="pull-right" data-purchase-product="0"
                                                            id="totalQtyProduct">({{ $purchase->total_qty }})</span></p>
                                                    <input type="hidden" name="total_qty"
                                                        value="{{ $purchase->total_qty }}" />
                                                </th>
                                                <th>{{ __('total_product') }}<br>
                                                    <p><span class="pull-right" data-product="0"
                                                            id="totalProduct">{{ $purchase->item }}</span></p>
                                                    <input type="hidden" name="item" id="item"
                                                        value="{{ $purchase->item }}" />
                                                </th>
                                                <th>{{ __('sub_total') }}<br>
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="subTotal">{{ $purchase->total_cost }}</span>
                                                    <input type="hidden" name="total_cost"
                                                        value="{{ $purchase->total_cost }}" />
                                                </th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <tr>
                                                <td colspan="2">{{ __('order_tax') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="order_tax">{{ $purchase->order_tax_rate ?? '0.00' }}</span>
                                                </td>
                                                <input type="hidden" name="order_tax"
                                                    value="{{ $purchase->order_tax_rate ?? '0.00' }}" />
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('order_discount') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span
                                                        id="order_discount">{{ $purchase->order_discount ?? '0.00' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ __('shipping_cost') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span
                                                        id="shipping_cost">{{ $purchase->order_discount ?? '0.00' }}</span>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tfoot class="table-bg-color">
                                            <tr>
                                                <td colspan="2">{{ __('grand_total') }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="font-size: 15px;">{{ getSettings('currency_symbol') ?? '$' }}</span>
                                                    <span id="grand_total">{{ $purchase->grand_total ?? '0.00' }}</span>
                                                </td>
                                                <input type="hidden" name="grand_total"
                                                    value="{{ $purchase->grand_total }}" />
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-select name="payment_method" :required="false" title="{{ __('payment_method') }}"
                                            id="payment-method" placeholder="{{ __('select_a_option') }}">
                                            @foreach ($paymentMethods as $paymentMethod)
                                                <option
                                                    {{ isset($purchase->payment_method->value) && $purchase->payment_method->value == $paymentMethod->value ? 'selected' : '' }}
                                                    value="{{ $paymentMethod->value }}">{{ $paymentMethod->value }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label class="mb-2" for="amount">{{ __('amount') }}</label>
                                            <input onkeypress="onlyNumber(event)" type="text" id="amount"
                                                class="form-control" placeholder="{{ __('enter_your_payable_amount') }}" name="paid_amount"
                                                value="{{ $purchase->paid_amount }}">
                                            @error('paid_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3" id="account-list"
                                        style="display: {{ isset($purchase->payment_method->value) && $purchase->payment_method->value == 'Bank' ? 'block' : 'none' }}">
                                        <div class="form-group">
                                            <x-select name="account_id" :required="false" title="{{ __('bank_account') }}"
                                                placeholder="{{ __('select_a_option') }}">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"> {{ $account->name }}</option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('note') }}</label>
                                    <textarea name="note" id="summernote">{!! $purchase->note !!}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row  mt-3">
                                    <div class="col-12 col-md-6">
                                        <a href="{{ route('purchase.index') }}"
                                            class="btn mb-sm-2 reset-btn w-100">{{ __('back') }}</a>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn common-btn w-100">{{ __('update_and_save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="attachDocumentModal" tabindex="-1" role="dialog"
            aria-labelledby="attachDocumentLabel" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header card-header-color">
                        <h5 class="modal-title" id="attachDocumentLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times text-white"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ $purchase->document->file ?? asset('public/default/default.jpg') }}" width="100%"
                            alt="">
                    </div>
                </div>
            </div>
        </div>
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
