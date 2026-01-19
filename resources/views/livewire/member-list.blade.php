<div>
	<div class="mb-4 row">
		<input
			type="text"
			wire:model.live.debounce.300ms="searchTerm"
			placeholder="Search members..."
			class="px-4 py-2 border rounded w-80"
		/>
		{{-- <a
			href="{{ route('members.form', ['member' => new \App\Models\Member()]) }}"
			class="px-4 py-2 bg-blue-500 text-white rounded"
		>{{ __('Add New Member') }}</a> --}}
	</div>
	<table class="min-w-full divide-y divide-gray-200">
		<thead class="bg-gray-50">
			<tr>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member ID</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
				<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
			</tr>
		</thead>
		<tbody class="bg-white divide-y divide-gray-200">
			@foreach($members as $member)
				<tr wire:click="showMember({{ $member->id }})" class="hover:bg-gray-100 cursor-pointer">
					<td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">{{ $member->member_id }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">{{ $member->full_name }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-lg text-gray-900">{{ $member->phone_number }}</td>
					<td class="px-6 py-4 whitespace-nowrap text-2xl 
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
