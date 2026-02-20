<div>
<!-- Staff Current Info Card -->
@if (session()->has('fail'))
    <div class="max-w-3xl mx-auto mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <span class="block sm:inline">{{ session('fail') }}</span>
    </div>
@endif
@if (session()->has('success'))
    <div class="max-w-3xl mx-auto mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold">{{ __('messages.staff_profile') }}</h2>
                <p class="text-indigo-100">{{ __('messages.current_information_overview') }}</p>
            </div>
        </div>
        <div x-data="{ open: false }">
            <button 
                @click="open=true"           
                class="bg-white text-purple-600 font-bold py-2 px-4 rounded-full hover:bg-purple-100 transition duration-300">
                {{ __('messages.pay_cheque') }}
            </button>
            <div x-show="open" class="modal">
                <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
                        <p class="text-sm text-gray-600 mb-4">{{ __('messages.confirm_action') }}</p>
                        <div class="flex justify-end space-x-3">
                            <button @click="open = false" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300 transition">{{ __('messages.cancel_action') }}</button>
                            <button @click="open = false; $wire.payout();" class="px-4 py-2 text-sm text-white bg-purple-600 rounded hover:bg-purple-700 transition">{{ __('messages.confirm_action_button') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="p-6 space-y-6">
        <!-- Full Name -->
        <div class="bg-gray-50 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-top space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('messages.full_name') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $staff->full_name }} </p>
                        <small class="text-sm text-gray-500">{{ __('messages.total_sales_amount') }}: <span class="text-xl font-bold text-green-700">${{ number_format($staff->total_sales_amount, 2) }}</span></small><br />
                        <small class="text-sm text-gray-500">{{ __('messages.commission_amount') }}: <span class="text-xl font-bold text-green-700">${{ number_format($staff->commission_amount, 2) }}</span></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaction Amount -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div class="flex items-top space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('messages.total_salary') }}</p>
                        <p class="text-2xl font-bold text-green-700">${{ number_format($staff->total_salary, 2) }}</p>
                        <p class="text-sm text-gray-500">{{ __('messages.base_salary') }}: ${{ number_format($staff->base_salary, 2) }} </p> 
                        <p class="text-sm text-gray-500">{{ __('messages.bonus') }}: ${{ number_format($staff->bonus, 2) }}</p>
                    </div>
                </div>
                <div class="text-green-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Dayoff Days -->
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div class="flex items-top space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('messages.total_dayoff_days') }}</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $staff->number_of_dayoffs }} {{ __('messages.dayoff_dates') }}</p>
                        <p class="text-sm text-gray-500">{{ __('messages.dayoff_dates') }}: 
                            {{ implode(', ', $staff->dayoff_dates) }}
                        </p>
                    </div>
                </div>
                <div class="text-blue-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Payout History -->
        
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border border-purple-200">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4z"/>
                            <path d="M14 6a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h8zM6 8a2 2 0 012 2v1a2 2 0 01-2 2H5v-1a2 2 0 012-2h1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('messages.payout_history') }}</p>
                    </div>
                </div>
                <div class="text-purple-600">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 max-h-48 overflow-y-auto pr-2">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.payout_base') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.total_sales_amount') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.payout_total') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.payout_date') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($staff->payoutHistories as $payout)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm font-semibold text-gray-800">${{ number_format($payout->base_salary, 2) }}</td>
                                <td class="px-4 py-2 text-sm font-semibold text-gray-800">${{ number_format($payout->sales_amount, 2) }}</td>
                                <td class="px-4 py-2 text-sm font-semibold text-gray-800">${{ number_format($payout->total_amount, 2) }}</td>
                                <td class="px-4 py-2 text-xs text-gray-500">{{ $payout->created_at->format('M d, Y') }}</td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 text-sm py-4">{{ __('messages.no_payout_records_yet') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</div>
