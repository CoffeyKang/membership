<x-app-layout>

<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.backup_manager') }}</h1>
        
        <!-- Status Messages -->
        @if($message)
            <div class="mb-6 p-4 rounded-md {{ 
                $messageType === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 
                ($messageType === 'error' ? 'bg-red-100 text-red-800 border border-red-200' : 
                'bg-blue-100 text-blue-800 border border-blue-200') 
            }}">
                {{ $message }}
                <button 
                    wire:click="clearMessage" 
                    class="float-right text-lg font-bold text-gray-600 hover:text-gray-800"
                >&times;</button>
            </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.create_backup') }}</h2>
                <p class="text-sm text-gray-600 mb-3">{{ __('messages.create_new_database_backup_now') }}</p>
                <button 
                    wire:click="createBackup" 
                    {{ $isBackingUp ? 'disabled' : '' }}
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded disabled:opacity-50"
                >
                    {{ $isBackingUp ? __('messages.creating') : __('messages.create_backup_now') }}
                </button>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.clean_old_backups') }}</h2>
                <p class="text-sm text-gray-600 mb-3">{{ __('messages.remove_backups_older_than_policy') }}</p>
                <button 
                    wire:click="cleanupBackups" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded"
                >
                    {{ __('messages.clean_up') }}
                </button>
            </div>
            
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messages.scheduled_backups') }}</h2>
                <p class="text-sm text-gray-600 mb-3">{{ __('messages.automatic_backups_scheduled') }}</p>
                <div class="flex items-center">
                    <div class="h-3 w-3 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-sm">{{ __('messages.active') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Backups Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">{{ __('messages.available_backups') }}</h2>
                <p class="text-gray-600 mt-1">{{ __('messages.list_of_all_available_backups') }}</p>
            </div>
            
            <div class="overflow-x-auto">
                @if(count($backups) > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.disk') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.path') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.size') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($backups as $backup)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $backup['disk'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $backup['date'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $backup['path'] }}">{{ $backup['path'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $backup['size'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button 
                                            wire:click="downloadBackup('{{ $backup['path'] }}')"
                                            class="text-blue-600 hover:text-blue-900"
                                        >
                                            {{ __('messages.download') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">{{ __('messages.no_backups_found') }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Information Panel -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="font-medium text-blue-800 mb-2">{{ __('messages.backup_configuration') }}</h3>
            <ul class="list-disc pl-5 text-sm text-blue-700 space-y-1">
                <li>{{ __('messages.daily_backups_at_2am') }}</li>
                <li>{{ __('messages.backups_retained_for_days') }}</li>
                <li>{{ __('messages.weekly_backups_retained') }}</li>
                <li>{{ __('messages.monthly_backups_retained') }}</li>
                <li>{{ __('messages.yearly_backups_retained') }}</li>
            </ul>
        </div>
    </div>
</div>

</x-app-layout>