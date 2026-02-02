<div>
	@if (session('status'))
		<div class="w-full p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
			<svg class="inline w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
			</svg>
			{{ session('status') }}
		</div>
	@endif
	<div class="flex flex-row flex-row w-full justify-between">
		<a href="{{ route('members.index') }}" class="inline-flex w-40 items-center px-4 py-2 bg-blue-600 text-white text-md font-bold rounded hover:bg-blue-700 transition">
			&larr; {{ __('messages.back_to_member_list') }}
		</a>
		<a 
			href="{{ route('members.edit', ['member' => $member]) }}" 
			class="inline-flex items-center justify-center w-40 px-4 py-2 bg-yellow-500 text-white text-md font-bold rounded hover:bg-yellow-600 transition">
			<svg class="inline w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L15.232 5.232z"/>
			</svg>
			{{ __('messages.edit_member') }}
		</a>
	</div>
	
	<div class="flex flex-col lg:flex-row w-full">
		<div class="w-full lg:w-1/2">
			<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 {{ $member->is_primary ? 'border-4 border-yellow-400' : 'border-2 border-blue-200' }}">
				<div class="p-4 sm:p-6">
					<h2 class="text-lg sm:text-xl font-bold text-blue-700 mb-4 sm:mb-6">{{ __('messages.personal_information') }}</h2>
					<div class="space-y-3 sm:space-y-4">
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-sm sm:text-base font-semibold">{{ __('messages.member_id') }}</span>
							<span class="text-blue-700 text-base sm:text-lg font-bold">{{ $member->member_id }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-sm sm:text-base font-semibold">{{ __('messages.full_name') }}</span>
							<span class="text-gray-900 text-base sm:text-lg font-bold">{{ $member->full_name }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-sm sm:text-base font-semibold">{{ __('messages.member_level') }}</span>
							<span class="text-gray-900 text-base sm:text-lg font-bold">{{ $member->is_primary ? __('messages.primary_member') : __('messages.normal_member') }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-sm sm:text-base font-semibold">{{ __('messages.phone_number') }}</span>
							<span class="text-gray-900 text-base sm:text-lg font-bold">{{ $member->phone_number }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-sm sm:text-base font-semibold">{{ __('messages.balance') }}</span>
							<span class="text-green-700 text-base sm:text-lg font-bold">{{ $member->balance }}</span>
						</div>
					</div>
				</div>
				<div class="flex flex-col sm:flex-row justify-between p-4 mt-4 sm:mt-6 gap-2 sm:gap-0">
					<button 
						wire:click="$set('showSpendModal', true)" 
						class="w-full sm:w-auto px-6 sm:px-12 py-3 sm:py-4 bg-red-600 text-white rounded font-semibold hover:bg-red-700 transition">
						{{ __('messages.spend') }}
					</button>
					<button 
						wire:click="$set('showDepositModal', true)" 
						class="w-full sm:w-auto px-6 sm:px-12 py-3 sm:py-4 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition">
						{{ __('messages.deposit') }}
					</button>
				</div>
			</div>
		
			<!-- Spend Modal -->
			@if($showSpendModal)
				@livewire('spend-form', ['member' => $member])
			@endif

			<!-- Deposit Modal -->
			@if($showDepositModal)
				@livewire('deposit-form', ['member' => $member])
			@endif
		</div>
		
		<div class="w-full lg:w-1/2 lg:pl-8 mt-8 lg:mt-0">
			<livewire:deposit-history :$member />
		</div>

	</div>

	<div class="w-full mt-8 border-t pt-6">
		@foreach($member->transactions as $transaction)
			<div class="border-b py-2">
				<div class="flex flex-col sm:flex-row sm:justify-between">
					<div>
						<span class="font-semibold">{{ __('messages.staff_id') }}</span> {{ $transaction->staff->nick_name }} @ <b>{{ $transaction->created_at->format('Y-m-d H:i') }}</b>
					</div>
					<div>
						<span class="font-semibold">{{ __('messages.amount') }}</span> {{ $transaction->amount }}
					</div>
				</div>
				<div class="text-sm text-gray-600">
					<span class="font-semibold">{{ __('messages.notes') }}</span> {{ $transaction->notes ?? __('messages.n_a') }}
				</div>
			</div>
		@endforeach	
	</div>
</div>
