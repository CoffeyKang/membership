<div>
	@if (session('status'))
		<div class="w-full p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
			<svg class="inline w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
			</svg>
			{{ session('status') }}
		</div>
	@endif
	
	<div class="flex w-full justify-between items-center">
		<a href="{{ route('members.edit', $member) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded hover:bg-yellow-600 transition">
			{{ __('Edit Member') }}
		</a>
		<a href="{{ route('members.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
			&larr; {{ __('Back to Member List') }}
		</a>
	</div>
	
	<div class="flex w-full">
		<div class="w-1/2">
			<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 {{ $member->is_primary ? 'border-4 border-yellow-400' : 'border-2 border-blue-200' }}">
				<div class="p-6">
					<h2 class="text-xl font-bold text-blue-700 mb-6">{{ __('Personal Information') }}</h2>
					<div class="space-y-4">
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('Member ID') }}</span>
							<span class="text-blue-700 text-lg font-bold">{{ $member->member_id }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('Full Name') }}</span>
							<span class="text-gray-900 text-lg font-bold">{{ $member->full_name }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('Member Level') }}</span>
							<span class="text-gray-900 text-lg font-bold">{{ $member->is_primary ? __('Primary') : __('Normal') }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('Phone Number') }}</span>
							<span class="text-gray-900 text-lg font-bold">{{ $member->phone_number }}</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="text-gray-600 text-base font-semibold">{{ __('Balance') }}</span>
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
				@livewire('spend-form', ['member' => $member])
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

	<div class="w-full mt-8 border-t pt-6">
		@foreach($member->transactions as $transaction)
			<div class="border-b py-2">
				<div class="flex justify-between">
					<div>
						<span class="font-semibold">{{ __('Staff ID:') }}</span> {{ $transaction->staff->nick_name }} @ <b>{{ $transaction->created_at->format('Y-m-d H:i') }}</b>
					</div>
					<div>
						<span class="font-semibold">{{ __('Amount:') }}</span> {{ $transaction->amount }}
					</div>
				</div>
				<div class="text-sm text-gray-600">
					<span class="font-semibold">{{ __('Notes:') }}</span> {{ $transaction->notes ?? __('N/A') }}
				</div>
			</div>
		@endforeach	
	</div>
		
</div>
