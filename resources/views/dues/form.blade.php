<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $dueDetails->due->name ?? null)" required
        autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-input-label for="take_amount" :value="__('Take Amount')" />
    <x-text-input id="take_amount" name="take_amount" type="number" class="mt-1 block w-full" :value="old('take_amount', $dueDetails->take_amount ?? null)" required
        autofocus autocomplete="take_amount" />
    <x-input-error class="mt-2" :messages="$errors->get('take_amount')" />
</div>
@isset($dueDetails)
    <div>
        <x-input-label for="return_amount" :value="__('Return Amount')" />
        <x-text-input id="return_amount" name="return_amount" type="number" class="mt-1 block w-full" :value="old('return_amount', $dueDetails->return_amount ?? null)"
            required autofocus autocomplete="return_amount" />
        <x-input-error class="mt-2" :messages="$errors->get('return_amount')" />
    </div>
@endisset

<div>
    <x-input-label for="due_date" :value="__('Due Date')" />
    <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', dateformat($dueDetails->due_date ?? now()))" required
        autofocus autocomplete="due_date" />
    <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
</div>
