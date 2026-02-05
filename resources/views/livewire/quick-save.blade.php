<div>
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 border border-red-400 mb-4 p-3 rounded text-sm md:text-base">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 border border-green-400 mb-4 p-3 rounded text-sm md:text-base">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="flex flex-col md:flex-row">
        <!-- Left Column: Form -->
        <div class="w-full md:w-1/2 p-3 md:p-4 m-1 md:m-2 border rounded shadow bg-white">
            <form wire:submit.prevent="saveQuick">
                <!-- Hairstylist -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.hairstylist') }}</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:flex md:flex-row gap-2 md:gap-5 max-h-48 md:max-h-64 overflow-y-auto">
                        @foreach ($staff as $item)
                            <div
                                class="mb-2 p-3 md:p-5 border-2 rounded-lg shadow-sm bg-yellow-50 cursor-pointer {{ $selectedStaffId === $item->id ? 'border-green-500' : 'border-gray-300' }}"
                                wire:click="$set('selectedStaffId', {{ $item->id }})"
                            >
                                {{ $item->nick_name }}
                            </div>
                        @endforeach
                    </div>
                    @error('selectedStaffId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Member -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.member') }}</label>
                    <!-- Live search input on mobile, read-only span on desktop -->
                    <div class="w-full md:hidden">
                        <input 
                            type="text"
                            class="w-full p-2 border rounded text-sm md:hidden mb-2"
                            placeholder="{{ __('messages.type_member_name') }}"
                            wire:model.live.debounce.300ms="memberSearch"
                           value="{{ $selectedMemberID ? $members->find($selectedMemberID)?->full_name : '' }}"
                        >
                        @if(!empty($memberSearch))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 md:max-h-100 overflow-y-auto">
                                @forelse($memberResults as $member)
                                    <div
                                        class="mb-2 p-2 md:p-3 border-2 rounded-lg shadow-sm {{ $member->is_primary ? 'bg-yellow-200' : '' }} cursor-pointer {{ $selectedMemberID === $member->id ? 'border-green-500' : 'border-gray-300' }}"
                                        wire:click="selectClient({{ $member->id }})"
                                    >
                                        <h2 class="text-sm md:text-base font-semibold">{{ $member->full_name }} <small>({{ $member->phone_number }})</small></h2>
                                        <p class="text-xs md:text-sm"> {{ __('messages.last_transaction') }}: {{ $member->transactions->last()?->created_at ? $member->transactions->last()?->created_at->format('Y-m-d H:i') : __('messages.n_a') }}</p>
                                        <p class="text-xs md:text-sm"><strong>{{ __('messages.balance') }}: <span class="font-bold">{{ $member->balance }}</span></strong></p>
                                    </div>
                                @empty
                                    <div class="p-2 text-gray-500 text-sm md:text-base">{{ __('messages.no_members_found') }}</div>
                                @endforelse
                            </div>
                        @endif
                    </div>
                
                    
                    <span class="hidden md:inline text-sm md:text-base">{{ $selectedMemberID ? $members->find($selectedMemberID)?->full_name : __('messages.walkin_client') }}</span>
                    @error('selectedMemberID') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.amount') }}</label>
                    <input type="number" wire:model="amount" class="w-full p-2 border rounded text-sm md:text-base" min="0" step="0.01" placeholder="{{ __('messages.enter_amount') }}" />
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Amount -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.confirm_amount') }}</label>
                    <input type="number" wire:model="confirmAmount" class="w-full p-2 border rounded text-sm md:text-base" min="0" step="0.01" placeholder="{{ __('messages.confirm_amount') }}" />
                    @error('confirmAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.notes') }}</label>
                    <textarea wire:model="notes" class="w-full p-2 border rounded text-sm md:text-base" rows="3" placeholder="{{ __('messages.enter_notes') }}"></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 md:px-6 rounded shadow text-sm md:text-base">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Search & Transactions -->
        <div class="w-full md:w-1/2 p-3 md:p-4 m-1 md:m-2 border rounded shadow bg-white">
            <!-- Search Member -->
            <div class="mb-3 hidden md:block">
                <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.search_member') }}</label>
                <div class="flex gap-2 mb-2">
                    <input
                        type="text"
                        class="flex-1 p-2 border rounded text-sm md:text-base"
                        placeholder="{{ __('messages.type_member_name') }}"
                        wire:model.live.debounce.300ms="memberSearch"
                    />
                    <button 
                        type="button" 
                        wire:click="selectWalkinClient" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 md:px-4 rounded shadow text-sm md:text-base">
                        {{ __('messages.walkin_client') }}
                    </button>
                </div>

                @if(!empty($memberSearch))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 md:max-h-64 overflow-y-auto">
                        @forelse($memberResults as $member)
                            <div
                                class="mb-2 p-2 md:p-3 border-2 rounded-lg shadow-sm {{ $member->is_primary ? 'bg-yellow-200' : '' }} cursor-pointer {{ $selectedMemberID === $member->id ? 'border-green-500' : 'border-gray-300' }}"
                                wire:click="selectClient({{ $member->id }})"
                            >
                                <h3 class="text-sm md:text-base font-semibold">{{ $member->full_name }} <small>({{ __('messages.member_id') }}: {{ $member->member_id }})</small></h3>
                                <p class="text-xs md:text-sm">{{ $member->phone_number }}</p>
                                <p class="text-xs md:text-sm"> {{ __('messages.last_transaction') }}: {{ $member->transactions->last()?->created_at ? $member->transactions->last()?->created_at->format('Y-m-d') : __('messages.n_a') }}</p>
                                <p class="text-xs md:text-sm"><strong>{{ __('messages.balance') }}: <span class="font-bold">{{ $member->balance }}</span></strong></p>
                            </div>
                        @empty
                            <div class="p-2 text-gray-500 text-sm md:text-base">{{ __('messages.no_members_found') }}</div>
                        @endforelse
                    </div>
                @endif
            </div>
            <!-- Signature Pad -->
            <div class="mb-3">
                @livewire('signature-pad', ['memberId' => $selectedMemberID] , ['key' => 'pad-key:' . $selectedMemberID])
            </div>
        </div>
    </div>
</div>
