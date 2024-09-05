@extends('layouts.app')
@section('title', __('product_edit'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <form id="product" action="{{ route('product.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-header d-flex align-items-center card-header-color">
                        <span class="list-title text-white">{{ __('new_product') }}</span>
                    </div>
                    <div class="card-body">
                        @include('product.form')
                        <div class="row">
                            <div class="col-md-12" style="text-align: right">
                                <button type="submit" class="btn common-btn">{{ __('update_and_save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $("#digital").hide();
        $("#combo-section").hide();
        $("#diffPrice-section").hide();
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


    @if ($product->is_promotion_price == 1)
        <script>
            $("#promotion_price").show();
        </script>
    @endif

    @if ($product->type->value == 'Combo')
        <script>
            $("#batch-option").hide();
        </script>
    @endif

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
