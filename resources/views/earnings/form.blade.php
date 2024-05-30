<div>
    <x-input-label for="description" :value="__('Description')" />
    <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $earningDetails->description ?? null)"
        required autofocus autocomplete="description" />
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div>
    <x-input-label for="amount" :value="__('Amount')" />
    <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" :value="old('amount', $earningDetails->amount ?? null)" required
        autofocus autocomplete="amount" />
    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
</div>