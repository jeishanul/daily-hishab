@extends('layouts.app')

@section('title', __('brands'))

@section('content')
    <section>
        <div class="container-fluid">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between">
                    <x-section-header title="brands" />
                    <x-create-button target="createModal" name="add_brand" />
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table dataTable table-hover" style="width: 100%">
                            <thead class="table-bg-color">
                                <tr>
                                    <th class="not-exported">{{ __('sl') }}</th>
                                    <th>{{ __('image') }}</th>
                                    <th>{{ __('brand') }}</th>
                                    <th class="not-exported">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $key => $brand)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ $brand->media->file }}" height="30" width="30"></td>
                                        <td>{{ $brand->title }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <x-edit-button target="brandEditModal_{{ $brand->id }}" />
                                            <!-- Delete Button -->
                                            <x-delete-button route="{{ route('brand.delete', $brand->id) }}" />

                                            <!-- Edit Modal -->
                                            <div id="brandEditModal_{{ $brand->id }}" tabindex="-1" role="dialog" data-backdrop="static" 
                                                 aria-labelledby="brandEditModalLabel_{{$brand->id}}" aria-hidden="true" class="modal fade text-left">
                                                <div role="document" class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('put')

                                                            <!-- Modal Header -->
                                                            <x-modal-header header="edit_brand"
                                                            id="brandEditModalLabel_{{$brand->id}}" />

                                                            <!-- Modal Body -->
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <!-- Title Input -->
                                                                    <div class="col-md-12 mb-3">
                                                                        <x-inputGroup name="title" title="{{ __('title') }}" type="text" 
                                                                            :required="true" 
                                                                            value="{{ $brand->title ?? old('title') }}" 
                                                                            placeholder="{{ __('enter_your_brand_title') }}" />
                                                                    </div>

                                                                    <!-- Image Input -->
                                                                    <div class="col-md-12 mb-3">
                                                                        <x-fileInputGroup name="image" title="{{ __('image') }}" 
                                                                            :required="false" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                 <!-- Close Button -->
                                                                <x-modal-close-button />
                                                                <!-- Submit Button -->
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
                <!-- End Card Body -->
            </div>
        </div>
    </section>

    <!-- Create Modal -->
    <div id="createModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="brandCreateModalLabel" aria-hidden="true" 
         class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Modal Header -->
                    <x-modal-header header="new_brand" id="brandCreateModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row">
                            <!-- Title Input -->
                            <div class="col-md-12 mb-3">
                                <x-inputGroup name="title" title="{{ __('title') }}" type="text" :required="true"
                                              value="{{ old('title') }}" placeholder="{{ __('enter_your_brand_title') }}" />
                            </div>

                            <!-- Image Input -->
                            <div class="col-md-12 mb-3">
                                <x-fileInputGroup name="image" title="{{ __('image') }}" :required="true" />
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                         <!-- Close Button -->
                         <x-modal-close-button />
                         <!-- Submit Button -->
                         <x-common-button name="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Create Modal -->
@endsection
