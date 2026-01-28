<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.staff_info') }}
        </h2>
    </x-slot>
    <div class="py-12 ">
        <livewire:staff-info :staff="$staff" />
    </div>
</x-app-layout>