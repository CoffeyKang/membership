<div>
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.full_name') }}</th>
                    <th class="hidden md:block px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.unpaid_amount') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.today_amount') }}</th>
                    <th class="hidden md:block px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.number_of_working_days') }}</th>
                    <th class="hidden md:block px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.number_of_dayoffs') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions_column') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($staff as $member)
                    <tr class="hover:bg-gray-100 cursor-pointer {{ $member->is_left ? 'bg-red-100 hover:bg-red-200' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->full_name }}</td>
                        <td class="hidden md:block px-6 py-4 whitespace-nowrap text-sm text-gray-500">$ {{ $member->unpaidAmount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$ {{ $member->today_amount }}</td>
                        <td class="hidden md:block px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->numberOfWorkingDays }}</td>
                        <td class="hidden md:block px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->numberOfDayoffs }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('staff.show', $member->id) }}" class="hidden md:block text-indigo-600 hover:text-indigo-900">{{ __('messages.edit') }}</a>
                            <a 
                                href="{{ route('staff.management.transactions', $member->id) }}" 
                                class="hidden md:block text-indigo-600 hover:text-indigo-900 ml-4"
                                wire:navigate
                            >{{ __('messages.transactions') }}</a>
                            <a 
                                href="{{ route('staff.management.payout', $member->id) }}" 
                                class="text-red-600 hover:text-red-900 ml-4"
                                wire:navigate
                            >{{ __('messages.pay_cheque_action') }}</a>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>

        <div class="bg-gray-50 px-6 py-4 text-center">
            <div class="text-sm font-medium mb-4">
                {{ __('messages.today_transactions') }}: <span class="text-2xl text-green-700 font-bold"> $ {{ number_format($todayTransactions, 2) }} </span>
            </div>
            <div class="text-sm font-medium">
                <a href="{{ route('staff.create') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('messages.add_new_staff') }}</a>
            </div>
        </div>
    </div>
</div>
