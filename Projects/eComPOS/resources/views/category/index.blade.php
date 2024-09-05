@extends('layouts.app')
@section('title', __('categories'))
@section('content')
    <section>
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between">
                <x-section-header title="categories" />
                <div>
                    <!-- Print Button -->
                    <button type="button" class="btn print-btn" onclick="printCategory()">
                        <i class="fa fa-print"></i>&nbsp;&nbsp;{{ __('print') }}
                    </button>
                    <!-- Import Button -->
                    <button type="button" class="btn import-btn" data-toggle="modal" data-target="#categoryImportModal">
                        <i class="fa fa-file-import"></i>&nbsp;&nbsp;{{ __('import') }}
                    </button>
                    <!-- Add Category Button -->
                    <button type="button" class="btn common-btn" data-toggle="modal" data-target="#createCategoryModal">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('add_category') }}
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
                                <th>{{ __('name') }}</th>
                                <th class="not-exported">{{ __('action') }}</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $category->media->file ?? asset('public/default/default.jpg') }}" height="40" width="40">
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <x-edit-button target="editCategoryModal_{{ $category->id }}" />

                                        <!-- Delete Button -->
                                        <x-delete-button route="{{ route('category.delete', $category->id) }}" />

                                        <!-- Edit Modal -->
                                        <div id="editCategoryModal_{{ $category->id }}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="categoryEditModalLabel_{{ $category->id }}" aria-hidden="true" class="modal fade text-left">
                                            <div role="document" class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <x-modal-header header="edit_category" id="categoryEditModalLabel_{{ $category->id }}" />
                                                        <div class="modal-body">
                                                            <div class="row mb-2">
                                                                <!-- Name Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-inputGroup 
                                                                        name="name" 
                                                                        title="{{ __('name') }}" 
                                                                        type="text" 
                                                                        :required="true" 
                                                                        value="{{ $category->name ?? old('name') }}" 
                                                                        placeholder="{{ __('enter_your_category_name') }}" 
                                                                    />
                                                                </div>
                                                                <!-- Image Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-fileInputGroup 
                                                                        name="image" 
                                                                        title="{{ __('image') }}" 
                                                                        :required="false" 
                                                                    />
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

    <!-- Create Category Modal -->
    <div id="createCategoryModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="createCategoryModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Modal Header -->
                    <x-modal-header header="new_category" id="createCategoryModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row mb-2">
                            <!-- Category Name Input -->
                            <div class="col-md-12 mb-3">
                                <x-inputGroup 
                                    name="name" 
                                    title="{{ __('name') }}" 
                                    type="text" 
                                    :required="true" 
                                    value="{{ old('name') }}" 
                                    placeholder="{{ __('enter_your_category_name') }}" 
                                />
                            </div>
                            <!-- Category Image Input -->
                            <div class="col-md-12 mb-3">
                                <x-fileInputGroup 
                                    name="image" 
                                    title="{{ __('image') }}" 
                                    :required="false" 
                                />
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

    <!-- Import Modal -->
    <div id="categoryImportModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="categoryImportModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('category.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Modal Header -->
                    <x-modal-header header="import_category" id="categoryImportModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row mb-3">
                            <!-- File Input -->
                            <div class="col-md-12 mb-3">
                                <x-fileInputGroup 
                                    name="file" 
                                    title="{{ __('import') }}" 
                                    :required="true" 
                                />
                            </div>
                            <!-- Download Sample Button -->
                            <div class="col-md-12">
                                <a href="{{ route('download.category.sample') }}" class="btn common-btn w-100">{{ __('download') }}</a>
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
@push('scripts')
    <script>
        function printCategory() {
            const length = $('select[name="dataTable_length"]').val();
            window.location.href = "{{ route('category.print') }}" + "?length=" + length
        }
    </script>
@endpush
