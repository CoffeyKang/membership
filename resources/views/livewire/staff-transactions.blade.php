<div>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.staff_transactions_for') . $staff->full_name }}
        </h2>   
        <small>
            {{ __('messages.total') }}: <b class="text-green-600 font-bold text-2xl">{{ $this->totalTransactions() }}</b>, 
            {{ __('messages.total_amount') }}: <b class="text-green-600 font-bold text-2xl">${{ number_format($this->totalAmount(), 2) }}</b>
            </small>
    </div>
    <div class="mt-4 flex justify-between items-center">
        <div class="mt-4 flex gap-2">
            <button
                wire:click="setPeriod('today')"
                class="px-4 py-2 text-sm font-medium rounded-md w-[150px]
                    {{ $period === 'today' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ __('messages.today') }} 
            </button>
            <button
                wire:click="setPeriod('this_month')"
                class="px-4 py-2 text-sm font-medium rounded-md w-[150px]
                    {{ $period === 'this_month' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ __('messages.this_month') }}
            </button>
            <button
                wire:click="setPeriod('this_year')"
                class="px-4 py-2 text-sm font-medium rounded-md w-[150px]
                    {{ $period === 'this_year' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ __('messages.this_year') }}
            </button>
        </div>    
        <div>
            <button
                wire:click="setPeriod('all')"
                class="px-4 py-2 text-sm font-medium rounded-md w-[150px]
                    {{ $period === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ __('messages.all_transactions') }}
            </button>
        </div>

    </div>
    <div class="mt-6 bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.staff_name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.amount') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.note') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($this->staffTransactions as $transaction)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $staff->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($transaction->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->note }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">{{ __('messages.no_transactions_found') }}</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500"> {{ $this->staffTransactions->links() }} </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</div>
