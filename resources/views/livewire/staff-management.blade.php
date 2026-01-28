<div>
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unpaid Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Today Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"># of Working Days</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"># of Dayoffs</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($staff as $member)
                    <tr class="hover:bg-gray-100 cursor-pointer {{ $member->is_left ? 'bg-red-100 hover:bg-red-200' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $member->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$ {{ $member->unpaidAmount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$ {{ $member->today_amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->numberOfWorkingDays }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->numberOfDayoffs }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('staff.show', $member->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a 
                                href="{{ route('staff.management.transactions', $member->id) }}" 
                                class="text-indigo-600 hover:text-indigo-900 ml-4"
                                wire:navigate
                            >Transactions</a>
                            <a 
                                href="{{ route('staff.management.payout', $member->id) }}" 
                                class="text-red-600 hover:text-red-900 ml-4"
                                wire:navigate
                            >Pay Cheque!</a>
                        </td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50">
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        Total Today Transactions: <span class="text-2xl text-green-700 font-bold"> $ {{ number_format($todayTransactions, 2) }} </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                        <a href="{{ route('staff.create') }}" class="text-indigo-600 hover:text-indigo-900">Add New Staff</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
