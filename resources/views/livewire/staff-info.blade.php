<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
@if(session()->has('success'))
    <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 border border-red-200">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl {{ $is_left ? 'border-2 border-red-500' : '' }}">
        <div class="p-8 space-y-6">
            <h3 class="text-2xl font-semibold text-gray-800 border-b pb-4 flex justify-between items-center">
                <span>{{ $staff->full_name }}</span>
                <a href="{{ route('staff-management.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                    {{ __('messages.back_to_staff_list') }}
                </a>
            </h3>
            <small class="text-gray-500">{{ __('messages.join_at') }} {{ $created_at }}</small>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.full_name') }}</label>   
                    <input 
                        wire:model="full_name" 
                        d="full_name" 
                        name="full_name" 
                        type="text" 
                        class="mt-1 block w-full" required autofocus autocomplete="full_name" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.nick_name') }}</label>
                    <input 
                        wire:model="nick_name" 
                        d="nick_name" 
                        name="nick_name" 
                        type="text" 
                        class="mt-1 block w-full" required autofocus autocomplete="nick_name" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.phone_number') }}</label>
                    <input 
                        wire:model="phone_number" 
                        d="phone_number" 
                        name="phone_number" 
                        type="text" 
                        class="mt-1 block w-full" required autofocus autocomplete="phone_number" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.base_salary') }}</label>
                    <input 
                        wire:model="base_salary" 
                        d="base_salary" 
                        name="base_salary" 
                        type="number" 
                        step="100"
                        min="0"
                        class="mt-1 block w-full" required autofocus autocomplete="base_salary" 
                    />      
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.monthly_minimum_sales_amount') }}</label>
                    <input 
                        wire:model="monthly_minimum_sales_amount" 
                        d="monthly_minimum_sales_amount" 
                        name="monthly_minimum_sales_amount" 
                        type="number" 
                        step="100"
                        min="0"
                        class="mt-1 block w-full" required autofocus autocomplete="monthly_minimum_sales_amount" 
                    />   
                </div>   

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.commission_rate') }}</label>
                    <input 
                        wire:model="commission_rate" 
                        d="commission_rate" 
                        name="commission_rate" 
                        type="number" 
                        step="0.01"
                        min="0"
                        max="1"
                        class="mt-1 block w-full" required autofocus autocomplete="commission_rate" 
                    />   
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">{{ __('messages.bonus') }}</label>
                    <input 
                        wire:model="bonus" 
                        d="bonus" 
                        name="bonus" 
                        type="number" 
                        step="100"
                        min="0"
                        class="mt-1 block w-full" required autofocus autocomplete="bonus" 
                    />   
                </div>
                <div></div>

                <div> 
                    <button 
                        wire:click="toggleLeft"
                        class="px-4 py-2 w-[120px] rounded 
                            {{ $is_left ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} 
                            text-white transition
                            {{ empty($staff->id) ? 'hidden' : '' }}
                        "
                        >
                        {{ $is_left ? __('messages.left') : __('messages.working') }}
                    </button>
                </div>
                <div class="flex justify-end">
                    <button 
                        wire:click="save"
                        class="px-4 py-2 w-[120px] rounded bg-blue-500 hover:bg-blue-600 text-white transition">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </div>
        </div>
        
    </div>
    
</div>