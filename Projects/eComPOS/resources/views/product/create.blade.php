@extends('layouts.app')
@section('title', __('new_product'))
@section('content')
    <style>
        .jpreview-image {
            width: 308px;
            height: 250px;
            margin: 10px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;

        }
    </style>
    <section class="forms">
        <div class="container-fluid">
            <form id="product" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header d-flex align-items-center card-header-color">
                        <span class="list-title text-white">{{ __('new_product') }}</span>
                    </div>
                    <div class="card-body">
                        @include('product.form')
                        <div class="row">
                            <div class="col-md-12" style="text-align: right">
                                <button type="submit" class="btn common-btn">{{ __('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    <script>
        $("#digital").hide();
        $("#combo-section").hide();
        $("#promotion_price").hide();

        $('select[name="type"]').on("change", function() {
            const value = $(this).val();
            if (value == 'Combo') {
                $("#combo-section").show();
                $("#batch-option").hide();
            } else {
                $("#combo-section").hide();
                $("#batch-option").show();
            }
        });
        $(document).on('click', '#add-image', function() {
            $('#image-section').append(`<div class="row">
                            <div class="col-md-11 mb-3">
                                <x-input type="file" title="{{ __('image') }}" name="more_image[]"
                                    :required="false" placeholder="" />
                            </div>
                            <div class="col-md-1" style="margin-top: 30px">
                                <button type="button" class="btn btn-danger remove-image"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>`);
        })
        $(document).on('click', '.remove-image', function() {
            $(this).parent().parent().remove();
        })
    </script>
    <script>
        $('select[name="unit_id"]').on("change", function() {
            var unitID = $(this).val();
            if (unitID) {
                $.ajax({
                    url: "{{ route('product.sale.unit') }}",
                    type: "GET",
                    data: {
                        id: unitID,
                    },
                    dataType: "json",
                    success: function(res) {
                        $('select[name="sale_unit_id"]').empty();
                        $('select[name="purchase_unit_id"]').empty();
                        $.each(res.data.unit, function(key, value) {
                            $('select[name="sale_unit_id"]').append(
                                '<option value="' + key + '">' + value + "</option>"
                            );
                            $('select[name="purchase_unit_id"]').append(
                                '<option value="' + key + '">' + value + "</option>"
                            );
                        });
                    },
                });
            } else {
                $('select[name="sale_unit_id"]').empty();
                $('select[name="purchase_unit_id"]').empty();
            }
        });
    </script>
    <script src="{{ asset('public/assets/product/create.js') }}"></script>
@endpush
