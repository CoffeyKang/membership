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
        <div class="w-full md:p-4 m-1 md:m-2 border rounded shadow bg-white">
            <form wire:submit.prevent="">
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
                {{-- Member --}}
                <div class="grid grid-cols-[1fr_auto] gap-0">
                    <input 
                        type="text"
                        class="w-full p-2 border rounded text-sm md:text-base md:hidden"
                        placeholder="{{ __('messages.type_member_name') }}"
                        wire:model.live.debounce.300ms="memberSearch"
                        value="{{ $selectedMemberID ? $members->find($selectedMemberID)?->full_name : '' }}"
                    >
                    <button 
                        type="button" 
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 transition duration-200 rounded"
                        wire:click="selectWalkinClient"
                        >
                        {{ __('messages.walkin_client') }}
                    </button>
                </div>
                @if(!empty($memberSearch))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-48 md:max-h-100 overflow-y-auto mt-4">
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
                <!-- Amount -->
                <div class="mb-4 mt-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.amount') }}</label>
                    <input type="number" wire:model="amount" class="w-full p-2 border rounded text-sm md:text-base" min="0" step="0.01" placeholder="{{ __('messages.enter_amount') }}" />
                    @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.date') }}</label>
                    <input type="date" wire:model="date" class="w-full p-2 border rounded text-sm md:text-base" />
                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <span class="block text-gray-700 font-bold mb-2 text-sm md:text-base">{{ __('messages.notes') }}</span>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mb-2">
                        @foreach($services as $service)
                            <div 
                                class="inline-block items-center text-center border border-gray-300 bg-gray-100 rounded-md cursor-pointer px-4 py-4 min-w-[80px] {{ in_array($service, $selectedServices) ? 'bg-green-500 text-white' : '' }}"
                                wire:click="addService('{{ $service }}')"
                            >
                                {{ $service }}
                            </div>
                        @endforeach
                    </div>
                    <span class="text-sm md:text-base text-green-500"><b>{{ __('messages.notes') }}:</b>  <span class="text-lg font-bold text-black">{{ $notes }}</span></span>
                </div>

                <div class="flex justify-center w-full">
                    <button 
                        type="submit" 
                        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 w-full md:px-6 py-4 rounded shadow text-sm md:text-base"
                        wire:click="saveQuick"
                        >
                        {{ __('messages.submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
