@extends('layouts.app')
@section('title', __('banners'))
@section('content')
    <section>
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between">
                <x-section-header title="banners" />
                <div>
                    <!-- Add Banner Button -->
                    <button type="button" class="btn common-btn" data-toggle="modal" data-target="#createBannerModal">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('add_banner') }}
                    </button>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover dataTable" style="width: 100%">
                        <!-- Table Head -->
                        <thead class="table-bg-color">
                            <tr>
                                <th>{{ __('sl') }}</th>
                                <th>{{ __('image') }}</th>
                                <th>{{ __('title') }}</th>
                                <th>{{ __('url') }}</th>
                                {{-- <th>{{ __('status') }}</th> --}}
                                <th class="not-exported">{{ __('action') }}</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $banner->media->file ?? asset('public/default/default.jpg') }}"
                                            height="30" width="30">
                                    </td>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->url }}</td>
                                    {{-- <td>dsfds</td> --}}
                                    <td>
                                        <!-- Edit Button -->
                                        <x-edit-button target="editBannerModal_{{ $banner->id }}" />

                                        <!-- Delete Button -->
                                        <x-delete-button route="{{ route('banner.delete', $banner->id) }}" />

                                        <!-- Edit Modal -->
                                        <div id="editBannerModal_{{ $banner->id }}" tabindex="-1" role="dialog"
                                            data-backdrop="static"
                                            aria-labelledby="bannerEditModalLabel_{{ $banner->id }}" aria-hidden="true"
                                            class="modal fade text-left">
                                            <div role="document" class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('banner.update', $banner->id) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <x-modal-header header="edit_banner"
                                                            id="bannerEditModalLabel_{{ $banner->id }}" />
                                                        <div class="modal-body">
                                                            <div class="row mb-2">
                                                                <!-- Title Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-inputGroup name="title"
                                                                        title="{{ __('title') }}" type="text"
                                                                        :required="true"
                                                                        value="{{ $banner->title ?? old('title') }}"
                                                                        placeholder="{{ __('enter_your_banner_title') }}" />
                                                                </div>
                                                                <!-- Image Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-fileInputGroup name="image"
                                                                        title="{{ __('image') }} (1250x450)" :required="false" />
                                                                </div>
                                                                <!-- Banner URL Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-inputGroup name="url"
                                                                        title="{{ __('url') }}" type="text"
                                                                        :required="true" value="{{ $banner->url ?? old('url') }}"
                                                                        placeholder="{{ __('enter_your_banner_url') }}" />
                                                                </div>
                                                            </div>
                                                        </div>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Create Banner Modal -->
    <div id="createBannerModal" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="createBannerModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Modal Header -->
                    <x-modal-header header="new_banner" id="createBannerModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row mb-2">
                            <!-- Banner Title Input -->
                            <div class="col-md-12 mb-3">
                                <x-inputGroup name="title" title="{{ __('title') }}" type="text" :required="true"
                                    value="{{ old('title') }}" placeholder="{{ __('enter_your_banner_title') }}" />
                            </div>
                            <!-- Banner Image Input -->
                            <div class="col-md-12 mb-3">
                                <x-fileInputGroup name="image" title="{{ __('image') }} (1250x450)" :required="false" />
                            </div>
                            <!-- Banner URL Input -->
                            <div class="col-md-12 mb-3">
                                <x-inputGroup name="url" title="{{ __('url') }}" type="text" :required="true"
                                    value="{{ old('url') }}" placeholder="{{ __('enter_your_banner_url') }}" />
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
@endsection
