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
        <div class="mb-2 text-gray-600">Phone: {{ $staff->phone_number }}</div>
        <div class="mb-4">
            <span class="px-2 py-1 rounded-full text-xs {{ $staff->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $staff->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <button wire:click="toggleActive"
            class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition">
            {{ $staff->is_active ? 'Deactivate' : 'Activate' }}
        </button>
    </div>
</div>
