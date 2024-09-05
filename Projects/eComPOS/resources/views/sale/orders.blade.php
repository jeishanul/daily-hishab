@extends('layouts.app')
@section('title', __('Orders'))
@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="list-title">{{ __('Orders') }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table purchase-list dataTable table-hover" style="width: 100%">
                            <thead class="table-bg-color">
                                <tr>
                                    <th class="not-exported">{{ __('sl') }}</th>
                                    <th>{{ __('date') }}</th>
                                    <th>{{ __('total_product') }}</th>
                                    <th>{{ __('total_discount') }}</th>
                                    <th>{{ __('total_tax') }}</th>
                                    <th>{{ __('total_price') }}</th>
                                    <th>{{ __('grand_total') }}</th>
                                    <th>{{ __('payment_method') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th class="not-exported">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ dateFormat($order->created_at) }}</td>
                                        <td>{{ $order->total_qty }}</td>
                                        <td>{{ numberFormat($order->total_discount) }}</td>
                                        <td>{{ numberFormat($order->total_tax) }}</td>
                                        <td>{{ numberFormat($order->total_price) }}</td>
                                        <td>{{ numberFormat($order->grand_total) }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        @if ($order->status == 0)
                                            <td><span class="badge badge-warning">Pending</span></td>
                                        @elseif($order->status == 1)
                                            <td><span class="badge badge-success">On Process</span></td>
                                        @elseif($order->status == 2)
                                            <td><span class="badge badge-success">Delivered</span></td>
                                        @endif
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn common-btn py-0 px-1" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="">
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-item d-flex gap-2 align-items-center"
                                                        data-toggle="modal"
                                                        data-target="#sale_details_{{ $order->id }}">
                                                        <i class="fa fa-eye text-info"></i>
                                                        {{ __('view') }}
                                                    </a>
                                                    @if ($order->status == 0)
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item d-flex gap-2 align-items-center order-action"
                                                            data-id="{{ $order->id }}" data-status="1">
                                                            <i class="fa fa-tasks text-warning"></i>
                                                            {{ __('on_process') }}
                                                        </a>
                                                    @elseif ($order->status == 1)
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-item d-flex gap-2 align-items-center order-action"
                                                            data-id="{{ $order->id }}" data-status="2">
                                                            <i class="fa fa-font-awesome text-success"></i>
                                                            {{ __('delivered') }}
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('sale.draft.delete', $order->id) }}" id="delete"
                                                        class="dropdown-item d-flex gap-2 align-items-center">
                                                        <i class="fa fa-trash text-danger"></i>
                                                        {{ __('Delete') }}
                                                    </a>

                                                </div>
                                            </div>
                                            <div id="sale_details_{{ $order->id }}" tabindex="-1" role="dialog"
                                                data-backdrop="static" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true" class="modal fade text-left saleDetails">
                                                <div role="document" class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="branding-logo">
                                                                <img src="{{ getSettings('logo_path') ? asset(getSettings('logo_path')) : asset('public/logo/logo.png') }}"
                                                                    alt="" style="width:250px">
                                                            </div>
                                                            <div>
                                                                {{ __('order_details') }}
                                                            </div>
                                                            <div style="margin-right: 15px">
                                                                <button type="button" id="close-btn"
                                                                data-dismiss="modal" aria-label="Close"
                                                                class="close"><span aria-hidden="true"><i
                                                                        class="fa fa-times"></i></span></button>
                                                            </div>
                                                        </div>

                                                        <div id="sale-content" class="modal-body">
                                                            <strong>{{ __('date') }}:</strong>
                                                            {{ dateFormat($order->created_at) }}<br>
                                                            <strong>{{ __('reference') }}:</strong>
                                                            {{ $order->reference_no }}
                                                            @if ($order->customer)
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="float-right">
                                                                            <strong>{{ __('to') }}:</strong><br>{{ $order->customer?->name }}<br>{{ $order->customer?->email }}<br>{{ $order->customer?->phone }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <table
                                                                class="table table-bordered product-purchase-list mt-3 p-2">
                                                                <thead class="table-bg-color">
                                                                    <tr>
                                                                        <th>{{ __('sl') }}</th>
                                                                        <th>{{ __('product') }}</th>
                                                                        <th>{{ __('quantity') }}</th>
                                                                        <th>{{ __('tax') }}</th>
                                                                        <th>{{ __('price') }}</th>
                                                                        <th>{{ __('sub_total') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($order->productSales as $productSale)
                                                                        <tr>
                                                                            <td><strong>{{ $loop->iteration }}</strong>
                                                                            </td>
                                                                            <td>{{ $productSale->product->name }}
                                                                                [{{ $productSale->product->code }}]
                                                                            </td>
                                                                            <td>{{ $productSale->qty }}</td>
                                                                            <td>{{ numberFormat($productSale->product->price) }}
                                                                            </td>
                                                                            <td>{{ numberFormat($productSale->tax) }}
                                                                            </td>
                                                                            <td>{{ numberFormat($productSale->total) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    <tr>
                                                                        <td colspan="4" class="text-right">
                                                                            <strong>{{ __('total') }}:</strong>
                                                                        </td>
                                                                        <td>{{ numberFormat($order->total_tax) }}</td>
                                                                        <td>{{ numberFormat($order->total_price) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <strong>{{ __('order_tax') }}:</strong>
                                                                        </td>
                                                                        <td>{{ numberFormat($order->order_tax) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <strong>{{ __('order_discount') }}:</strong>
                                                                        </td>
                                                                        <td>{{ numberFormat($order->order_discount) }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <strong>{{ __('grand_total') }}:</strong>
                                                                        </td>
                                                                        <td>{{ numberFormat($order->grand_total) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="row my-2">
                                                                <div class="col-12 border-1">
                                                                    <p><strong>{{ __('note') }}:</strong>
                                                                        {!! $order->note !!}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('.order-action').on('click', function() {
            console.log('clicked');
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Confirm",
            }).then((result) => {
                if (result.value) {
                    window.location.href = 'order/status/update/' + id + '/' + status;
                }
            });
        });
    </script>
@endpush
