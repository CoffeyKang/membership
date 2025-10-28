<div>
    @if ($errors->any())
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 z-60">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 z-60">
                {{ session('success') }}
            </div>
        @endif


    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <h3 class="text-lg font-bold mb-4">{{ $member->full_name }} {{ __('Spend Amount') }} </h3>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Handled By Staff') }}
            </label>
            <div class="mb-4">
                @foreach ($staff as $staffMember)
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" 
                               wire:model.defer="selectedStaff" 
                               name="selectedStaff"
                               value="{{ $staffMember->id }}" 
                               class="form-radio">
                        <span class="ml-2">{{ $staffMember->nick_name }}</span>
                    </label>
                @endforeach
            </div>
            
            <label for="confirmSpendAmount" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Spend Amount') }}
            </label>
            <input type="number" wire:model.defer="spendAmount" class="w-full border rounded px-3 py-2 mb-4" placeholder="{{ __('Enter amount to spend') }}">
            
            <label for="confirmSpendAmount" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Confirm Deposit Amount') }}
            </label>
            <input type="number" 
                wire:model.defer="confirmSpendAmount"
                class="w-full border rounded px-3 py-2 mb-4" 
                placeholder="{{ __('Confirm the spend amount') }}
            ">

            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Notes') }} ({{ __('optional') }})
            </label>
            <textarea 
                wire:model.defer="notes"
                id="notes"
                class="w-full border rounded px-3 py-2 mb-4"
                placeholder="{{ __('Add any notes (optional)') }}"
                rows="3"
            ></textarea>
            <div class="flex justify-end space-x-2">
                <button wire:click="confirmSpend" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">{{ __('Confirm') }}</button>
                <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
