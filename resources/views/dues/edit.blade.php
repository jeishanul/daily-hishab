<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <span class="text-green-500">#{{ $dueDetails->due->name }}</span> {{ __('Edit Expense') }}
            </h2>
            <div class="flex items-center">
                <a href="{{ route('dues.index') }}"
                    class="text-white hover:text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 py-2 px-5 rounded-md">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl">
                    <form method="post" action="{{ route('dues.update', $dueDetails) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        @include('dues.form')

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update & Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
