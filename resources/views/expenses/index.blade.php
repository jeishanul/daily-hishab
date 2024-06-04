<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Expenses') }}
            </h2>
            <div class="flex items-center">
                <a href="{{ route('expenses.create') }}"
                    class="text-white hover:text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 py-2 px-5 rounded-md">
                    {{ __('Add New Expense') }}
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
                                {{ __('Amount') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200">
                        @if ($expenses->isNotEmpty())
                            @php($total = 0)
                            @foreach ($expenses as $expense)
                                @php($total += $expense->details->sum('amount'))
                                <tr>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 text-center py-4 whitespace-nowrap">
                                        {{ currencySymbol($expense->details->sum('amount')) }}
                                    </td>
                                    <td class="px-6 text-center py-4 whitespace-nowrap">
                                        {{ dateFormat($expense->date) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex items-center justify-center gap-2">
                                        <a href="{{ route('expenses.show', $expense) }}"
                                            class="text-blue-600 hover:text-blue-900">{{ __('Show') }}</a>

                                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-100 dark:bg-gray-800">
                                <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-md"
                                    colspan="1">
                                    {{ __('Total Expense Amount:') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-md">
                                    {{ currencySymbol($total) }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center" colspan="4">
                                    {{ __('No expenses found.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
