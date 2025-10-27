<div>
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
        <div class="p-6">
            <h2 class="text-xl font-bold text-blue-700 mb-4">{{ __('Deposit History') }}</h2>
            <table class="min-w-full divide-y divide-blue-200">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('Amount') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('Type') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
                            {{ __('Date') }}
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                {{ __('No deposit history found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
