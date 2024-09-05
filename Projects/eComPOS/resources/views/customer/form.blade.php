<div class="col-md-6 mb-3">
    <x-select name="customer_group_id" title="customer_group" :required="false" placeholder="select_a_option">
        @foreach ($customerGroups as $customerGroup)
            <option {{ isset($user->personalInfo) && $user->personalInfo->customer_group_id == $customerGroup->id ? 'selected' : '' }}
                value="{{ $customerGroup->id }}">{{ $customerGroup->name }} ({{ $customerGroup->percentage }}%)
            </option>
        @endforeach
    </x-select>
</div>
<div class="col-md-6 mb-3">
    <x-input name="name" title="name" type="text" :required="true" value="{{ $user->name ?? '' }}"
        placeholder="enter_your_customer_name" />
</div>
<div class="col-md-6 mb-3">
    <x-fileInputGroup name="image" title="image" :required="false" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="email" title="email_address" type="email" :required="false"
        value="{{ $user->email ?? '' }}" placeholder="enter_your_customer_email_address" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="phone" title="phone_number" type="text" :required="true"
        value="{{ $user->personalInfo->phone ?? '' }}" placeholder="enter_your_customer_phone_number" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup title="password" type="password" name="password" value="" :required="true"
        placeholder="enter_your_employee_password" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="city" title="city" type="text" :required="false" value="{{ $user->personalInfo->city ?? '' }}"
        placeholder="enter_your_customer_city" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="state" title="state" type="text" :required="false" value="{{ $user->personalInfo->state ?? '' }}"
        placeholder="enter_your_customer_state" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="zip_code" title="zip_code" type="text" :required="false"
        value="{{ $user->personalInfo->zip_code ?? '' }}" placeholder="enter_your_customer_zip_code" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup name="country" title="country" type="text" :required="false"
        value="{{ $user->personalInfo->country ?? '' }}" placeholder="enter_your_customer_country" />
</div>
<div class="col-md-12 mb-3">
    <x-inputGroup name="address" title="address" type="text" :required="false" value="{{ $user->personalInfo->address ?? '' }}"
        placeholder="enter_your_customer_address" />
</div>