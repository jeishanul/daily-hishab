<form method="post" action="{{ route('expenses.update', $expenseDetails) }}" class="mt-6 space-y-6">
    @csrf
    @method('PUT')
    <div>
        <x-input-label for="description" :value="__('Description')" />
        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $expenseDetails->description ?? null)"
            required autofocus autocomplete="description" />
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div>
        <x-input-label for="amount" :value="__('Amount')" />
        <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" :value="old('amount', $expenseDetails->amount ?? null)" required
            autofocus autocomplete="amount" />
        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
    </div>
    
    @if (!isset($expenseDetails->expense->date))
        <div>
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', dateFormat($expenseDetails->expense->date) ?? null)"
                required autofocus autocomplete="date" />
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>
    @endif


    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>
