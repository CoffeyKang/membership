<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Management List') }}
        </h2>
        <a href="{{ route('staff-management.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Back to Staff Management</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @livewire('StaffTransactions', ['staff' => $staff])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
