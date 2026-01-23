<div>
	@foreach ($staff as $person)
		<div class="inline-block m-2 align-top">
			<livewire:staff :staff="$person" :key="$person->id"/>
		</div>
	@endforeach
</div>
