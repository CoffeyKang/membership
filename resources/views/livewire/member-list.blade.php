<div>
	<div class="mb-4 flex justify-between items-center md:row">
		<input
			type="text"
			wire:model.live.debounce.300ms="searchTerm"
			placeholder="{{ __('messages.search_members') }}"
			class="px-4 py-2 border rounded w-50 md:w-84"
		/>
		
		<a 
			href="{{ route('members.create') }}" 
			class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded hover:bg-indigo-700 transition">
			{{ __('messages.create_new_member') }}
		</a>
	</div>
	<table class="min-w-full divide-y divide-gray-200">
		<thead class="bg-gray-50">
			<tr>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.full_name') }}</th>
				<th class="hidden md:block px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.phone_number') }}</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-right">{{ __('messages.balance') }}</th>
			</tr>
		</thead>
		<tbody class="bg-white divide-y divide-gray-200">
			@foreach($members as $member)
				<tr wire:click="showMember({{ $member->id }})" class="hover:bg-gray-100 cursor-pointer">
					<td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">{{ $member->full_name }}</td>
					<td class="hidden md:block px-6 py-4 whitespace-nowrap text-lg text-gray-900">{{ $member->phone_number }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-2xl  text-right
						@if($member->balance < 100)
							text-red-600
						@elseif($member->balance > 1000)
							text-yellow-500
							font-bold
						@else
							text-green-600
							font-semibold
						@endif
						text-gray-900">
						{{ $member->balance }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
