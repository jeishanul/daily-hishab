<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $dueDetails->due->name ?? null)" required
        autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-input-label for="take_amount" :value="__('Take Amount')" />
    <x-text-input id="take_amount" name="take_amount" type="number" class="mt-1 block w-full" :value="old('take_amount', $dueDetails->take_amount ?? null)"
        required autofocus autocomplete="take_amount" />
    <x-input-error class="mt-2" :messages="$errors->get('take_amount')" />
</div>

<div>
    <x-input-label for="due_date" :value="__('Due Date')" />
    <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', dateformat($dueDetails->due_date) ?? null)" required
        autofocus autocomplete="due_date" />
    <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
</div>
