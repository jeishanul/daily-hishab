<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <span class="text-green-500">#{{ dateFormat($expense->date) }}</span> {{ __('Expenses') }}
            </h2>
            <div class="flex items-center">
                <a href="{{ route('expenses.index') }}"
                    class="text-white hover:text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 py-2 px-5 rounded-md">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('SL') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Description') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Amount') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200">
                        @foreach ($expense->details as $details)
                            <tr>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{ $details->description }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{ currencySymbol($details->amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap flex items-center justify-center gap-2">
                                    <a href="{{ route('expenses.edit', $details) }}"
                                        class="text-blue-600 hover:text-blue-900">{{ __('Edit') }}</a>

                                    <form method="POST" action="{{ route('expenses.details.destroy', $details) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
