<div class="flex justify-center space-x-6">
    <div class="bg-white shadow rounded-lg p-6 flex flex-col items-center 
        {{ $staff->is_active ? 'border-2 border-yellow-400' : 'border-2 border-red-500' }}" 
        style="width: 250px;">
        <div class="mb-4">
            <div
                class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                {{ $staff->nick_name }}
            </div>
        </div>
        
        <div class="mb-2 text-gray-600">
            <span class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>{{ $staff->phone_number }}</span>
            </span>
        </div>

        <div class="mb-2 text-gray-600">
            <span class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>{{ __('messages.number_of_working_days') }}: {{ $staff->numberOfWorkingDays }}</span>
            </span>
            <span class="flex items-center space-x-2">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ __('messages.number_of_dayoffs') }}: {{ $staff->numberOfDayoffs }}</span>
            </span>
        </div>
        <div class="mb-4">
            <span class="px-2 py-1 rounded-full text-xs {{ $staff->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $staff->is_active ? __('messages.active') : __('messages.inactive') }}
            </span>
        </div>
        <button wire:click="toggleActive"
            class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition">
            {{ $staff->is_active ? __('messages.leave') : __('messages.activate') }}
        </button>
    </div>
</div>
