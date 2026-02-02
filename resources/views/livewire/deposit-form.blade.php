<div>
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
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
                {{ __('messages.deposit_successfully') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
            <h3 class="text-lg font-bold mb-4">{{ $member->full_name }} {{ __('messages.deposit_amount') }} </h3>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('messages.deposit_type') }}
            </label>
            <select 
                id="preset"
                wire:model="type"
                class="w-full border rounded px-3 py-2 mb-4"
            >
                <option value="">{{ __('messages.select_preset_value') }}</option>
                <option value=0>{{ __('messages.cash') }}</option>
                <option value=1>{{ __('messages.ali_pay') }}</option>
                <option value=2>{{ __('messages.wechat_pay') }}</option>
                <option value=3>{{ __('messages.old_money') }}</option>
            </select>
            
            <label for="depositAmount" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('messages.deposit_amount') }}
            </label>
            <input type="number" 
                wire:model.defer="depositAmount" 
                class="w-full border rounded px-3 py-2 mb-4" 
                placeholder="{{ __('messages.enter_amount_to_deposit') }}
            ">
            <label for="confirmDepositAmount" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('messages.confirm_deposit_amount') }}
            </label>
            <input type="number" 
                wire:model.defer="confirmDepositAmount"
                class="w-full border rounded px-3 py-2 mb-4" 
                placeholder="{{ __('messages.confirm_the_deposit_amount') }}
            ">
            <div class="flex justify-end space-x-2">
                <button 
                    wire:click="confirmDeposit" 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                >
                    {{ __('messages.confirm') }}
                </button>
                <button
                    wire:click="closeModal"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                    {{ __('messages.cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>
