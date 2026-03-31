<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('messages.deposite_records') }}</h2>
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label for="fromDate" class="text-sm font-medium text-gray-700">{{ __('messages.from_date') }}</label>
                <input 
                    type="date"
                    name="fromDate" 
                    wire:model.live="fromDate"
                    class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div class="flex items-center gap-2">
                <label for="tillDate" class="text-sm font-medium text-gray-700">{{ __('messages.till_date') }}</label>
                <input 
                    type="date"
                    name="tillDate" 
                    wire:model.live="tillDate"
                    class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>
    </div>
@if(isset($depositHistories) && count($depositHistories) > 0)
    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 bg-white">
            <thead class="bg-gradient-to-r from-indigo-500 to-purple-600">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">{{ __('ID') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">{{ __('messages.amount_column') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">{{ __('messages.type') }}</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">{{ __('messages.date') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($depositHistories as $history)
                    <tr class="hover:bg-indigo-50 transition-colors duration-200">
                        <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ $history->member->full_name ?? __('N/A') }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 font-bold">${{ number_format($history->amount ?? 0, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                {{ __(ucfirst($history->type_text ?? 'Unknown')) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $history->created_at ? $history->created_at->format('M d, Y') : __('N/A') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-white">
                <tr>
                    <td colspan="4" class="text-center text-sm text-gray-500">{{ __('messages.total') }}: {{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@else
    <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-lg">
        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <p class="text-sm">{{ __('No deposit history found') }}</p>
    </div>
@endif
</div>
