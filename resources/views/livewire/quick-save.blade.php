<div>
    <h1 class="font-bold font-xl">{{ __('Quick Save')}}</h1>
    <div class="flex">
        <div class="w-1/2 p-4 m-2 border rounded shadow bg-white">
            <form wire:submit.prevent="saveQuick">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Hairstylist</label>
                    <select wire:model="selectedStaffId" class="w-full p-2 border rounded">
                        <option value="">Select a hairstylist</option>
                        @foreach ($staff as $item)
                            <option value="{{ $item->id }}">{{ $item->nick_name }}</option>
                        @endforeach
                    </select>
                    @error('selectedStaffId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Member</label>
                    <span>{{ $selectedMemberID ? $members->find($selectedMemberID)->full_name : 'Walkin Client  ' }}</span>
                    @error('selectedMemberID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Amount</label>
                    <input type="number" wire:model="amount" class="w-full p-2 border rounded" min="0" step="0.01" placeholder="Enter amount" />
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Confirm Amount</label>
                    <input type="number" wire:model="confirmAmount" class="w-full p-2 border rounded" min="0" step="0.01" placeholder="Confirm amount" />
                    @error('confirmAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Notes</label>
                    <textarea wire:model="notes" class="w-full p-2 border rounded" rows="3" placeholder="Add notes..."></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <div class="w-1/2 p-4 m-2 border rounded shadow bg-white">
            <div class="mb-3">
                <label class="block text-gray-700 font-bold mb-2">Choose Hairstylist</label>
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
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 font-bold mb-2">Search Member</label>
                <input
                    type="text"
                    class="w-full p-2 border rounded mb-2"
                    placeholder="Type member name..."
                    wire:model.live.debounce.300ms="memberSearch"
                />
                @if(!empty($memberSearch))
                    <div class="flex flex-wrap max-h-64 overflow-y-auto gap-3">
                        @forelse($memberResults as $member)
                            <div
                                class="mb-2 p-3 border-2 rounded-lg min-w-20 shadow-sm bg-yellow-50 cursor-pointer {{ $selectedMemberID === $member->id ? 'border-green-500' : 'border-gray-300' }}"
                                wire:click="$set('selectedMemberID', {{ $member->id }})"
                            >
                                <h3>{{ $member->full_name }} <small>(ID: {{ $member->member_id }})</small> </h3>
                                <p>{{ $member->phone_number }}</p>
                                <p><strong>
                                    Balance: <span class="font-bold font-lg">{{ $member->balance }}</span>
                                </strong></p>
                            </div>
                        @empty
                            <div class="p-2 text-gray-500">No members found.</div>
                        @endforelse
                    </div>
                @endif

                @if (!empty($selectedMemberID))
                    {{-- add a latest 3 transaction records --}}
                @endif
            </div>
        </div>
    </div>
</div>
