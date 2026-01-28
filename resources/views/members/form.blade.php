<x-app-layout>
    <x-slot name="header">
        
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form wire:submit.prevent="save" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-gray-700">输入姓名</label>
                            <input
                                id="full_name"
                                type="text"
                                wire:model.defer="full_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="请输入姓名"
                                required
                            />
                            @error('full_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Phone Number -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">输入手机号</label>
                            <input
                                id="phone_number"
                                type="text"
                                wire:model.defer="phone_number"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="请输入手机号"
                                required
                            />
                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Balance -->
                        <div>
                            <label for="balance" class="block text-sm font-medium text-gray-700">{{ __('messages.balance') }}</label>
                            <input
                                id="balance"
                                type="number"
                                step="1"
                                wire:model.defer="balance"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="请输入余额"
                                min="0"
                                required
                            />
                            @error('balance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Primary --> {{ $is_primary }}
                        <div class="md:col-span-2">
                            <label for="is_primary" class="inline-flex items-center">
                                <input
                                    id="is_primary"
                                    type="checkbox"
                                    wire:model.defer="is_primary"
                                    class="rounded scale-150 border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                />
                                <span class="ml-2 text-sm text-gray-700">{{ __('messages.primary_member') }}</span>
                            </label>
                            @error('is_primary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a
                            href="{{ route('members.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ __('messages.cancel') }}
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            {{ $full_name ? '更新会员' : '创建会员' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
