<div>
    <div class="mt-6 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto  hidden md:block">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.full_name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.unpaid_amount') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.today_amount') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.number_of_working_days') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.number_of_dayoffs') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.actions_column') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($staff as $member)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 cursor-pointer {{ $member->is_left ? 'bg-red-50 hover:bg-red-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">$ {{ $member->unpaidAmount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">$ {{ $member->today_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $member->numberOfWorkingDays }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $member->numberOfDayoffs }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a 
                                    href="{{ route('staff.show', $member->id) }}" 
                                    class="text-indigo-600 hover:text-indigo-900 hover:underline mr-3">{{ __('messages.edit') }}</a>
                                <a 
                                    href="{{ route('staff.management.transactions', $member->id) }}" 
                                    class="text-blue-600 hover:text-blue-900 hover:underline mr-3"
                                    wire:navigate
                                >{{ __('messages.transactions') }}</a>
                                <a 
                                    href="{{ route('staff.management.payout', $member->id) }}" 
                                    class="text-red-600 hover:text-red-900 hover:underline"
                                    wire:navigate
                                >{{ __('messages.pay_cheque_action') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="overflow-x-auto md:hidden">
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.full_name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.today_amount') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('messages.actions_column') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($staff as $member)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 cursor-pointer {{ $member->is_left ? 'bg-red-50 hover:bg-red-100' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">$ {{ $member->today_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a 
                                    href="{{ route('staff.management.payout', $member->id) }}" 
                                    class="text-red-600 hover:text-red-900 hover:underline"
                                    wire:navigate
                                >{{ __('messages.pay_cheque_action') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 text-center border-t border-gray-200">
            <div class="text-sm font-medium mb-2">
                {{ __('messages.today_transactions') }}: <span class="text-2xl text-green-700 font-bold"> $ {{ number_format($todayTransactions, 2) }} </span>
            </div>
            <div class="text-sm font-medium">
                <a href="{{ route('staff.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('messages.add_new_staff') }}
                </a>
            </div>
        </div>
    </div>
</div>
