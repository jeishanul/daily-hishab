@extends('layouts.app')
@section('title', __('settings'))
@section('content')
    <section class="forms">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-card-header d-flex align-items-center card-header-color">
                            <x-section-header title="settings" class="text-white" />
                        </div>
                        <div class="card-body">
                            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="site_title" title="system_title"
                                            :required="true" value="{{ getSettings('site_title') ?? old('site_title') }}"
                                            placeholder="enter_your_system_title" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="site_logo" title="system_logo (size: 200x50)"
                                            :required="true" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="small_logo" title="{{ __('small_logo') }} (size: 50x50)" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="favicon" title="{{ __('favicon') }} (size: 32x32)" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="dark_logo" title="{{ __('dark_logo') }} (size: 200x50)" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="big_sale_banner"
                                            title="{{ __('big_sale_banner') }} (size: 1250x450)" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-fileInputGroup name="all_products_banner"
                                            title="{{ __('all_products_banner') }} (size: 1250x300)" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-select name="currency_id" title="currency" :required="true"
                                            placeholder="select_a_option">
                                            @foreach ($currencies as $currency)
                                                <option {{ getSettings('currency_id') == $currency->id ? 'selected' : '' }}
                                                    value="{{ $currency->id }}">{{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="developed_by" title="developed_by"
                                            :required="true" value="{{ getSettings('developed_by') ?? '' }}"
                                            placeholder="developed_by_description" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-select name="date_format" title="date_format" :required="true"
                                            placeholder="select_a_option">
                                            @foreach ($dateFormats as $dateFormat)
                                                <option
                                                    {{ getSettings('date_format') == $dateFormat->value ? 'selected' : '' }}
                                                    value="{{ $dateFormat }}">{{ $dateFormat }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="barcode_digits" title="barcode_digits"
                                            :required="true" value="{{ getSettings('barcode_digits') ?? '' }}"
                                            placeholder="enter_your_barcode_digits" />
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="copyright_text"
                                            title="{{ __('copyright_text') }}" :required="true"
                                            value="{{ getSettings('copyright_text') ?? '' }}"
                                            placeholder="{{ __('copyright_text') }}" />
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="copyright_url" title="{{ __('copyright_url') }}"
                                            :required="true" value="{{ getSettings('copyright_url') ?? '' }}"
                                            placeholder="{{ __('copyright_url') }}" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-select name="timezone" title="time_zone" :required="true" id="timezone"
                                            placeholder="select_a_option">
                                            @foreach ($zones as $zone)
                                                <option {{ $zone['zone'] == env('APP_TIMEZONE') ? 'selected' : '' }}
                                                    value="{{ $zone['zone'] }}">
                                                    {{ $zone['diff_from_GMT'] . ' - ' . $zone['zone'] }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="about_us" title="{{ __('about_us') }}"
                                            :required="true" value="{{ getSettings('about_us') ?? '' }}"
                                            placeholder="{{ __('about_us') }}" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <x-inputGroup type="text" name="phone" title="{{ __('phone_number') }}"
                                            :required="true" value="{{ getSettings('phone') ?? '' }}"
                                            placeholder="{{ __('enter_your_business_phone_number') }}" />
                                    </div>

                                    <div class="col-md-4">
                                        <x-inputGroup type="email" name="email" title="{{ __('email_address') }}"
                                            :required="true" value="{{ getSettings('email') ?? '' }}"
                                            placeholder="{{ __('enter_your_business_email_address') }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-inputGroup type="text" name="address" title="address" :required="true"
                                            value="{{ getSettings('address') ?? '' }}"
                                            placeholder="enter_your_business_address" />
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <x-inputGroup type="color" name="primary_color" title="primary_color"
                                            :required="true" value="{{ getSettings('primary_color') ?? '' }}"
                                            placeholder="" />
                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <x-inputGroup type="color" name="secondary_color" title="secondary_color"
                                            :required="true" value="{{ getSettings('secondary_color') ?? '' }}"
                                            placeholder="" />
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <x-input-radio-group name="currency_position" label="currency_position"
                                                    :setValue="getSettings('currency_position')" :options="['prefix', 'suffix']" :values="['Prefix', 'Suffix']"
                                                    :required="true" />
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <x-input-radio-group name="direction" label="direction" :setValue="getSettings('direction')"
                                                    :options="['ltr', 'rtl']" :values="['ltr', 'rtl']" :required="true" />
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <x-input-radio-group name="dark_mode" label="theme" :setValue="getSettings('dark_mode')"
                                                    :options="['light', 'dark']" :values="[0, 1]" :required="true" />
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <x-input-radio-group name="date_with_time" label="date_with_time"
                                                    :setValue="getSettings('date_with_time')" :options="['enable', 'disable']" :values="['Enable', 'Disable']"
                                                    :required="true" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="col-md-12">
                                                <x-textarea-group name="home_delivery_description"
                                                    title="home_delivery_description" :required="true"
                                                    placeholder="home_delivery_description"
                                                    value="{{ getSettings('home_delivery_description') ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="col-md-12">
                                                <x-textarea-group name="payment_security_description"
                                                    title="payment_security_description" :required="true"
                                                    placeholder="payment_security_description"
                                                    value="{{ getSettings('payment_security_description') ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="col-md-12">
                                                <x-textarea-group name="support_description" title="support_description"
                                                    :required="true" placeholder="support_description"
                                                    value="{{ getSettings('support_description') ?? '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group my-3">
                                    <x-common-button name="update_and_save" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#timezone').select2();
        });
    </script>
@endpush
