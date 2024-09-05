@extends('layouts.app')
@section('title', __('subcategories'))
@section('content')
    <section>
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between">
                <x-section-header title="subcategories" />
                <div>
                    <!-- Add Subcategory Button -->
                    <button type="button" class="btn common-btn" data-toggle="modal" data-target="#createSubcategoryModal">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('add_subcategory') }}
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
                                <th>{{ __('parent') }}</th>
                                <th>{{ __('number_of_product') }}</th>
                                <th class="not-exported">{{ __('action') }}</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            @foreach ($subcategories as $subcategory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $subcategory->media->file ?? asset('public/default/default.jpg') }}" height="40" width="40">
                                    </td>
                                    <td>{{ $subcategory->name }}</td>
                                    <td>{{ $subcategory->category->name ?? 'N/A' }}</td>
                                    <td>{{ $subcategory->product->count() ?? 0 }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <x-edit-button target="editSubcategoryModal_{{ $subcategory->id }}" />

                                        <!-- Delete Button -->
                                        <x-delete-button route="{{ route('category.delete', $subcategory->id) }}" />

                                        <!-- Edit Modal -->
                                        <div id="editSubcategoryModal_{{ $subcategory->id }}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="subcategoryEditModalLabel_{{ $subcategory->id }}" aria-hidden="true" class="modal fade text-left">
                                            <div role="document" class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('category.update', $subcategory->id) }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')
                                                        <x-modal-header header="edit_subcategory" id="subcategoryEditModalLabel_{{ $subcategory->id }}" />
                                                        <div class="modal-body">
                                                            <div class="row mb-2">
                                                                <!-- Name Input -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-inputGroup 
                                                                        name="name" 
                                                                        title="{{ __('name') }}" 
                                                                        type="text" 
                                                                        :required="true" 
                                                                        value="{{ $subcategory->name ?? old('name') }}" 
                                                                        placeholder="{{ __('enter_your_category_name') }}" 
                                                                    />
                                                                </div>
                                                                <!-- Parent Category Select -->
                                                                <div class="col-md-12 mb-3">
                                                                    <x-select 
                                                                        name="category_id" 
                                                                        title="{{ __('parent_category') }}" 
                                                                        placeholder="{{ __('select_a_option') }}" 
                                                                        :required="false"
                                                                    >
                                                                        @foreach ($categories as $category)
                                                                            <option 
                                                                                value="{{ $category->id }}" 
                                                                                {{ $subcategory->category_id == $category->id ? 'selected' : '' }}
                                                                            >
                                                                                {{ $category->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </x-select>
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

    <!-- Create Subcategory Modal -->
    <div id="createSubcategoryModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="createSubcategoryModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Modal Header -->
                    <x-modal-header header="new_subcategory" id="createSubcategoryModalLabel" />

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="row mb-2">
                            <!-- Subcategory Name Input -->
                            <div class="col-md-12 mb-3">
                                <x-inputGroup 
                                    name="name" 
                                    title="{{ __('name') }}" 
                                    type="text" 
                                    :required="true" 
                                    value="{{ old('name') }}" 
                                    placeholder="{{ __('enter_your_subcategory_name') }}" 
                                />
                            </div>
                            <!-- Parent Category Select -->
                            <div class="col-md-12 mb-3">
                                <x-select 
                                    name="category_id" 
                                    title="{{ __('parent_category') }}" 
                                    placeholder="{{ __('select_a_option') }}" 
                                    :required="false"
                                >
                                    @foreach ($categories as $category)
                                        <option 
                                            value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <!-- Subcategory Image Input -->
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

@endsection
@push('scripts')
@endpush
