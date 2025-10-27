<div>
	@if (session('status'))
		<div class="w-full p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
			<svg class="inline w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
			</svg>
			{{ session('status') }}
		</div>
	@endif
	
	<div class="flex w-full justify-end items-center">
		<a href="{{ route('members.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
			&larr; {{ __('Back to Member List') }}
		</a>
	</div>
	
	<div class="flex w-full">
		<div class="w-1/2">
			<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
				<div class="p-6">
					<h2 class="text-xl font-bold text-blue-700 mb-6">{{ __('Personal Information') }}</h2>
					<div class="space-y-4">
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('member.member_id') }}</span>
							<span class="text-blue-700 text-lg font-bold">{{ $member->member_id }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('member.full_name') }}</span>
							<span class="text-gray-900 text-lg font-bold">{{ $member->full_name }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('member.phone_number') }}</span>
							<span class="text-gray-900 text-lg font-bold">{{ $member->phone_number }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('member.balance') }}</span>
							<span class="text-green-700 text-lg font-bold">{{ $member->balance }}</span>
						</div>
					</div>
				</div>
				<div class="flex justify-between p-4 mt-6 ">
					<button 
						wire:click="$set('showSpendModal', true)" 
						class="px-12 py-4 bg-red-600 text-white rounded font-semibold hover:bg-red-700 transition">
						{{ __('Spend') }}
					</button>
					<button 
						wire:click="$set('showDepositModal', true)" 
						class="px-12 py-4 bg-green-600 text-white rounded font-semibold hover:bg-green-700 transition">
						{{ __('Deposit') }}
					</button>
				</div>
			</div>
		
			<!-- Spend Modal -->
			@if($showSpendModal)
				<div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
					<div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
						<h3 class="text-lg font-bold mb-4">{{ __('Spend Amount') }}</h3>
						<input type="number" wire:model.defer="spendAmount" class="w-full border rounded px-3 py-2 mb-4" placeholder="{{ __('Enter amount to spend') }}">
						<div class="flex justify-end space-x-2">
							<button wire:click="confirmSpend" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">{{ __('Confirm') }}</button>
							<button wire:click="$set('showSpendModal', false)" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">{{ __('Cancel') }}</button>
						</div>
					</div>
				</div>
			@endif

			<!-- Deposit Modal -->
			@if($showDepositModal)
				@livewire('deposit-form', ['member' => $member])
			@endif
		</div>
		
		<div class="w-1/2 pl-8">
			<livewire:deposit-history :$member />
		</div>
		
</div>
