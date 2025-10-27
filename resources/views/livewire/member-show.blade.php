<div>
    <div class="flex w-full justify-end items-center">
        <a href="{{ route('members.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition">
            &larr; {{ __('Back to Member List') }}
        </a>
    </div>
    <div class="flex w-full">
        <div class="w-2/5">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-blue-200">
                <div class="p-8">
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
        <div class="w-3/5 pl-8">
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden mt-8 border-2 border-gray-200">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('member.store_title') }}</h2>
                    <ul class="space-y-4">
                        @for($i = 0; $i < 10; $i++)
                            <li class="border-b pb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-blue-600">Random Item {{ $i + 1 }}</span>
                                    <span class="text-sm text-gray-500">{{ now()->subDays($i)->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="text-gray-700 mt-1">
                                    {{ Str::random(40) }}
                                </div>
                                <div class="text-green-700 font-bold mt-1">
                                    {{ __('member.amount') }}: {{ rand(10, 100) }}
                                </div>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
        
</div>
