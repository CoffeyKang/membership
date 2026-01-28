<div class="overflow-x-auto">
        @if (session('success'))
            <div class="w-full p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                <svg class="inline w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="w-full p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                <svg class="inline w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

    <table class="min-w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Staff</th>
                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Member</th>
                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Amount</th>
                <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Note</th>
                <th class="px-6 py-3 text-center text-sm font-semibold uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($transactions as $transaction)
                <tr class="hover:bg-indigo-50 transition-colors duration-200">
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $transaction->staff->full_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $transaction->member->full_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">${{ number_format($transaction->amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $transaction->notes }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2" x-data="{ open: false }">
                            <button 
                                class="text-red-600 hover:text-red-900 transition-colors duration-150" 
                                @click="open = ! open"
                                title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>

                            <div x-show="open" class="modal">
                                <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
                                        <p class="text-sm text-gray-600 mb-4">确定要执行此操作吗？</p>
                                        <div class="flex justify-end space-x-3">
                                            <button @click="open = false" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition">取消</button>
                                            <button @click="open = false; $wire.deleteTransaction({{ $transaction->id }});" class="px-4 py-2 text-sm text-white bg-purple-600 rounded hover:bg-purple-700 transition">确定</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
