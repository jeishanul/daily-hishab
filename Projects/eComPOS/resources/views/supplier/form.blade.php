<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="name" title="name" :required="true" value="{{ $user->name ?? '' }}"
        placeholder="enter_your_supplier_name" />
</div>
<div class="col-md-6 mb-3">
    <x-fileInputGroup name="image" title="image" :required="false" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="email" name="email" title="email_address" :required="true"
        value="{{ $user->email ?? '' }}" placeholder="enter_your_supplier_email_address" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="phone" title="phone_number" :required="true"
        value="{{ $user->personalInfo->phone ?? '' }}" placeholder="enter_your_supplier_phone_number" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="company_name" title="company_name" :required="true"
        value="{{ $user->personalInfo->company_name ?? '' }}" placeholder="enter_your_supplier_company_name" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="tax_no" title="tax_number" :required="false"
        value="{{ $user->personalInfo->tax_no ?? '' }}" placeholder="enter_your_supplier_tax_number" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="city" title="city" :required="true" value="{{ $user->personalInfo->city ?? '' }}"
        placeholder="enter_your_supplier_city" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="state" title="state" :required="false" value="{{ $user->personalInfo->state ?? '' }}"
        placeholder="enter_your_supplier_state" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="zip_code" title="post_code" :required="false"
        value="{{ $user->personalInfo->zip_code ?? '' }}" placeholder="enter_your_supplier_post_code" />
</div>
<div class="col-md-6 mb-3">
    <x-inputGroup type="text" name="country" title="country" :required="false" value="{{ $user->personalInfo->country ?? '' }}"
        placeholder="enter_your_supplier_country" />
</div>
<div class="col-md-12 mb-3">
    <x-inputGroup type="text" name="address" title="address" :required="true"
        value="{{ $user->personalInfo->address ?? '' }}" placeholder="enter_your_supplier_address" />
</div>
