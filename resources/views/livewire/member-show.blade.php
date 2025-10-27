<div>
	<div class="flex w-full justify-end items-center">
		<a href="{{ route('members.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
			&larr; {{ __('Back to Member List') }}
		</a>
	</div>
	<div class="flex w-full">
		<div class="w-1/2">
			<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
				<div class="p-6">
					<h2 class="text-xl font-bold text-blue-700 mb-4">{{ __('Personal Infomation') }}</h2>
					<div class="mb-4">
						<span class="block text-gray-600 text-lg font-semibold mb-1">{{ __('member.member_id') }}</span>
						<span class="block text-2xl text-blue-700 font-bold tracking-wide">{{ $member->member_id }}</span>
					</div>
					<div class="mb-4">
						<span class="block text-gray-600 text-lg font-semibold mb-1">{{ __('member.full_name') }}</span>
						<span class="block text-2xl text-gray-900 font-bold">{{ $member->full_name }}</span>
					</div>
					<div class="mb-4">
						<span class="block text-gray-600 text-lg font-semibold mb-1">{{ __('member.phone_number') }}</span>
						<span class="block text-2xl text-gray-900 font-bold">{{ $member->phone_number }}</span>
					</div>
					<div>
						<span class="block text-gray-600 text-lg font-semibold mb-1">{{ __('member.balance') }}</span>
						<span class="block text-2xl text-green-700 font-bold">{{ $member->balance }}</span>
					</div>
				</div>
			</div>
		</div>
		@if ($depositHistories)
			<div class="w-1/2 pl-8">
				<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
					<div class="p-6">
						<h2 class="text-xl font-bold text-blue-700 mb-4">{{ __('Deposit History') }}</h2>
						<table class="min-w-full divide-y divide-blue-200">
							<thead class="bg-blue-50">
								<tr>
									<th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
										{{ __('Amount') }}
									</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
										{{ __('Type') }}
									</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">
										{{ __('Date') }}
									</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-blue-100">
								@forelse($depositHistories as $history)
									<tr>
										<td class="px-6 py-4 whitespace-nowrap text-green-700 font-semibold">
											{{ number_format($history->amount, 2) }}
										</td>
										<td class="px-6 py-4 whitespace-nowrap text-green-700 font-semibold">
											{{ $history->type_text }}
										</td>
										<td class="px-6 py-4 whitespace-nowrap text-gray-700">
											{{ $history->created_at->format('Y-m-d H:i') }}
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="2" class="px-6 py-4 text-center text-gray-500">
											{{ __('No deposit history found.') }}
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		@endif
</div>
