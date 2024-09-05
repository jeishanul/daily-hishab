@extends('layouts.app')

@section('title', __('units'))

@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between">
                    <x-section-header title="units" />
                    <x-create-button target="unitCreateModal" name="add_unit" />
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dataTable table-hover" style="width: 100%">
                            <thead class="table-bg-color">
                                <tr>
                                    <th class="not-exported">{{ __('sl') }}</th>
                                    <th>{{ __('code') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('base_unit') }}</th>
                                    <th>{{ __('operator') }}</th>
                                    <th>{{ __('operation_value') }}</th>
                                    <th class="not-exported">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($units as $unit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $unit->code }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->baseUnit->name ?? 'N/A' }}</td>
                                        <td>{{ $unit->operator ?? 'N/A' }}</td>
                                        <td>{{ $unit->operation_value ?? 'N/A' }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <x-edit-button target="unitEditModal_{{ $unit->id }}" />
                                            <!-- Delete Button -->
                                            <x-delete-button route="{{ route('unit.delete', $unit->id) }}" />
                                        </td>
                                    </tr>

                                    <!-- Edit Unit Modal -->
                                    <div id="unitEditModal_{{ $unit->id }}" tabindex="-1" role="dialog"
                                        data-backdrop="static" aria-labelledby="unitEditModalLabel_{{ $unit->id }}"
                                        aria-hidden="true" class="modal fade text-left">
                                        <div role="document" class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('unit.update', $unit->id) }}" method="POST">
                                                    @csrf
                                                    <!-- Modal Header -->
                                                    <x-modal-header header="edit_unit"
                                                        id="unitEditModalLabel_{{ $unit->id }}" />

                                                    <!-- Modal Body -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <x-inputGroup name="name" type="text"
                                                                    title="{{ __('name') }}" :required="true"
                                                                    :value="$unit->name"
                                                                    placeholder="{{ __('enter_your_unit_name') }}" />
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <x-inputGroup name="code" type="text"
                                                                    title="{{ __('code') }}" :required="true"
                                                                    :value="$unit->code"
                                                                    placeholder="{{ __('enter_your_unit_code') }}" />
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <x-select name="base_unit_id" title="base_unit"
                                                                    placeholder="select_a_option" :required="false">
                                                                    @if ($units->isNotEmpty())
                                                                        @foreach ($units as $unit)
                                                                            <option
                                                                                {{ isset($unit->baseUnit->id) && $unit->baseUnit->id == $unit->id ? 'selected' : '' }}
                                                                                value="{{ $unit->id }}">
                                                                                {{ $unit->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </x-select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <x-inputGroup name="operator" type="text"
                                                                title="{{ __('operator') }}" :required="false"
                                                                :value="$unit->operator"
                                                                placeholder="{{ __('enter_your_operator_name') }}" />
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <x-inputGroup name="operation_value" type="text"
                                                                title="{{ __('operation_value') }}" :required="false"
                                                                type="number" :value="$unit->operation_value"
                                                                placeholder="{{ __('enter_your_operation_value') }}" />
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="modal-footer">
                                                        <x-modal-close-button />
                                                        <x-common-button name="update_and_save" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Create Unit Modal -->
    <div id="unitCreateModal" tabindex="-1" role="dialog" aria-labelledby="unitCreateModalLabel" aria-hidden="true"
        data-backdrop="static" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('unit.store') }}" method="POST">
                    @csrf
                    <!-- Modal Header -->
                    <x-modal-header header="new_unit" id="unitCreateModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <x-inputGroup name="name" type="text" title="{{ __('name') }}" :required="true"
                                    value="" placeholder="{{ __('enter_your_unit_name') }}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-inputGroup name="code" type="text" title="{{ __('code') }}" value=""
                                    :required="true" placeholder="{{ __('enter_your_unit_code') }}" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <x-select name="base_unit_id" title="base_unit" placeholder="select_a_option"
                                    :required="false">
                                    @if ($units->isNotEmpty())
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    @endif
                                </x-select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-inputGroup name="operator" type="text" title="{{ __('operator') }}" value=""
                                :required="false" placeholder="{{ __('enter_your_operator_name') }}" />
                        </div>
                        <div class="col-md-12 mb-3">
                            <x-inputGroup name="operation_value" type="text" title="{{ __('operation_value') }}"
                                value="" :required="false" type="number"
                                placeholder="{{ __('enter_your_operation_value') }}" />
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <x-modal-close-button />
                        <x-common-button name="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
