<div>
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 border border-red-400 mb-4 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 border border-green-400 mb-4 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex">
        <div class="w-1/2 p-4 m-2 border rounded shadow bg-white">
            <form wire:submit.prevent="saveQuick">
                <div class="mb-4">  
                    <label class="block text-gray-700 font-bold mb-2">{{ __('messages.hairstylist') }}</label>
                    <div class="flex flex-row max-h-64 overflow-y-auto gap-5">
                    @foreach ($staff as $item)
                        <div
                            class="mb-2 p-5 border-2 rounded-lg shadow-sm bg-yellow-50 cursor-pointer {{ $selectedStaffId === $item->id ? 'border-green-500' : 'border-gray-300' }}"
                            wire:click="$set('selectedStaffId', {{ $item->id }})"
                        >
                            {{ $item->nick_name }}
                        </div>
                    @endforeach
                </div>
                    @error('selectedStaffId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">{{ __('messages.member') }}</label>
                    <span>{{ $selectedMemberID ? $members->find($selectedMemberID)?->full_name : 'Walkin Client' }}</span>
                    @error('selectedMemberID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">{{ __('messages.amount') }}</label>
                    <input type="number" wire:model="amount" class="w-full p-2 border rounded" min="0" step="0.01" placeholder="Enter amount" />
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">{{ __('messages.confirm_amount') }}</label>
                    <input type="number" wire:model="confirmAmount" class="w-full p-2 border rounded" min="0" step="0.01" placeholder="Confirm amount" />
                    @error('confirmAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">{{ __('messages.notes') }}</label>
                    <textarea wire:model="notes" class="w-full p-2 border rounded" rows="3" placeholder="Add notes..."></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="w-1/2 p-4 m-2 border rounded shadow bg-white">
            <div class="mb-3">
                <label class="block text-gray-700 font-bold mb-2">{{ __('messages.search_member') }}</label>
                <div class="flex gap-2 mb-2">
                    <input
                        type="text"
                        class="flex-1 p-2 border rounded"
                        placeholder="Type member name..."
                        wire:model.live.debounce.300ms="memberSearch"
                    />
                    <button type="button" wire:click="$set('selectedMemberID', {{ $walkinClientID }}))" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
                        {{ __('messages.walkin_client') }}
                    </button>
                </div>
                @if(!empty($memberSearch))
                    <div class="flex flex-wrap max-h-64 overflow-y-auto gap-3">
                        @forelse($memberResults as $member)
                            <div
                                class="mb-2 p-3 border-2 rounded-lg min-w-20 shadow-sm {{ $member->is_primary ? 'bg-yellow-200' : 'bg-yellow-50' }}  cursor-pointer {{ $selectedMemberID === $member->id ? 'border-green-500' : 'border-gray-300' }}"
                                wire:click="selectClient({{ $member->id }})"
                            >
                                <h3>{{ $member->full_name }} <small>(ID: {{ $member->member_id }})</small> </h3>
                                <p>{{ $member->phone_number }}</p>
                                <p><strong>
                                    Balance: <span class="font-bold font-lg">{{ $member->balance }}</span>
                                </strong></p>
                            </div>
                        @empty
                            <div class="p-2 text-gray-500">{{ __('messages.no_members_found') }}</div>
                        @endforelse
                    </div>
                @endif

                @if (!empty($selectedMemberID) && !empty($memberTransactions))
                    <div class="w-full mt-8 border-t pt-6">
                        <p class="text-sm text-gray-600">{{ __('Last 3 Transactions') }}</p>
                        @foreach($memberTransactions as $transaction)
                            <div class="border-b py-2">
                                <div class="flex justify-between">
                                    <div>
                                        <span class="font-semibold">{{ __('Staff ID:') }}</span> {{ $transaction->staff->nick_name }} @ <b>{{ $transaction->created_at->format('Y-m-d H:i') }}</b>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">{{ __('Notes:') }}</span> {{ $transaction->notes ?? __('N/A') }}
                                </div>
                            </div>
                        @endforeach	
                    </div> 
                @endif
            </div>
        </div>
    </div>
</div>
