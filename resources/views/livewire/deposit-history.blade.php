<div>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
        <div class="p-6">
            <h2 class="text-xl font-bold text-blue-700 mb-4">{{ __('messages.deposit_history') }}</h2>
            <table class="min-w-full divide-y divide-blue-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('messages.amount') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('messages.type') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('messages.date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('messages.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-100">
                    @forelse($depositHistories as $history)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-green-700 font-semibold">
                                {{ number_format($history->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-700 font-semibold">
                                {{ $history->type_text }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $history->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div x-data="{ open: false }">
                                    <button @click="open = true" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
                                            <p class="text-sm text-gray-600 mb-4">{{ __('messages.confirm_to_delete_this_deposit') }}</p>
                                            <div class="flex justify-end space-x-3">
                                                <button @click="open = false" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition">{{ __('messages.cancel_delete') }}</button>
                                                <button @click="open = false; $wire.deleteDeposit({{ $history->id }});" class="px-4 py-2 text-sm text-white bg-purple-600 rounded hover:bg-purple-700 transition">{{ __('messages.delete') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                {{ __('messages.no_deposit_records_found') }}
                            </td>
                        </tr>
                    @endforelse
                        </tr>
                            <td colspan="3" class="px-6 py-4 text-center text-green-500">
                                {{ $depositHistories->links() }}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
