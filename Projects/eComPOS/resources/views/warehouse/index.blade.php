@extends('layouts.app')
@section('title', __('warehouses'))

@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <x-section-header title="warehouses" />
                    <x-create-button target="warehouseCreateModal" name="add_warehouse" />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dataTable table-hover" style="width: 100%">
                            <thead class="table-bg-color">
                                <tr>
                                    <th class="not-exported">{{ __('sl') }}</th>
                                    <th>{{ __('warehouse') }}</th>
                                    <th>{{ __('phone_number') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('address') }}</th>
                                    <th>{{ __('number_of_product') }}</th>
                                    <th class="not-exported">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->phone }}</td>
                                        <td>{{ $warehouse->email ?? 'N/A' }}</td>
                                        <td>{{ $warehouse->address }}</td>
                                        <td>{{ $warehouse->purchases->sum('total_qty') }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <x-edit-button target="warehouseEditModal_{{ $warehouse->id }}" />
                                                <!-- Delete Button -->
                                                <x-delete-button route="{{ route('warehouse.delete', $warehouse->id) }}" />

                                            <!-- Edit Modal -->
                                            <div id="warehouseEditModal_{{ $warehouse->id }}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="warehouseEditModalLabel_{{ $warehouse->id }}" aria-hidden="true" class="modal fade text-left">
                                                <div role="document" class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form method="post" action="{{ route('warehouse.update', $warehouse->id) }}">
                                                            @csrf
                                                            <x-modal-header header="edit_warehouse"
                                                            id="warehouseEditModalLabel_{{ $warehouse->id }}" />
                                                            <div class="modal-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6 mb-3">
                                                                        <x-inputGroup name="name" title="name" type="text" :required="true"
                                                                         placeholder="enter_your_warehouse_name" value="{{ $warehouse->name }}" />
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <x-inputGroup name="phone" title="phone_number" type="text" :required="true" 
                                                                        placeholder="enter_your_warehouse_phone_number" value="{{ $warehouse->phone }}" />
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <x-inputGroup name="email" title="email_address" type="email" :required="true"
                                                                            value="" placeholder="enter_your_warehouse_email_address" value="{{ $warehouse->email }}" />
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <x-inputGroup name="address" title="address" type="text" :required="true"
                                                                            value="" placeholder="enter_your_warehouse_address" value="{{ $warehouse->address }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <x-modal-close-button />
                                                                <x-common-button name="update_and_save" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Edit Modal -->
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

    <!-- Create Modal -->
    <div id="warehouseCreateModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="warehouseCreateModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('warehouse.store') }}" method="POST">
                    @csrf
                    <x-modal-header header="new_warehouse" id="warehouseCreateModalLabel" />
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <x-inputGroup name="name" title="name" type="text" :required="true"
                                 placeholder="enter_your_warehouse_name" value="" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-inputGroup name="phone" title="phone_number" type="text" :required="true" 
                                placeholder="enter_your_warehouse_phone_number" value="" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-inputGroup name="email" title="email_address" type="email" :required="true"
                                    value="" placeholder="enter_your_warehouse_email_address" value="" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-inputGroup name="address" title="address" type="text" :required="true"
                                    value="" placeholder="enter_your_warehouse_address" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <x-modal-close-button />
                        <x-common-button name="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Create Modal -->
@endsection
