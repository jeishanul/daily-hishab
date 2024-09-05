<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="name" class="mb-2">{{ __('name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="name" id="name"
                value="{{ Auth::user()->name }}" placeholder="{{ __('enter_your_name') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="phone_number" class="mb-2">{{ __('phone_number') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="phone_number"
                value="{{ Auth::user()->personalInfo?->phone }}" id="phone_number"
                placeholder="{{ __('enter_your_phone_number') }}" required>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="email" class="mb-2">{{ __('email_address') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="email" id="email"
                value="{{ Auth::user()->email }}" placeholder="{{ __('enter_your_email_address') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="country" class="mb-2">{{ __('country') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="country" id="country"
                value="{{ Auth::user()->personalInfo?->country }}" placeholder="{{ __('enter_your_country') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="city" class="mb-2">{{ __('city') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="city" id="city"
                value="{{ Auth::user()->personalInfo?->city }}" placeholder="{{ __('enter_your_city') }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="zip_code" class="mb-2">{{ __('zip_code') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="zip_code" id="zip_code"
                value="{{ Auth::user()->personalInfo?->zip_code }}"
                placeholder="{{ __('enter_your_zip_code') }}" required>
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group mb-3">
            <label for="address" class="mb-2">{{ __('address') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control checkout-input" name="address" id="address"
                value="{{ Auth::user()->personalInfo?->address }}" placeholder="{{ __('enter_your_address') }}" required>
        </div>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn address-btn">{{ __('save_address') }}</button>
    </div>
</div>

