<div>
    @if( $savedSignature )
        <div class="mt-4">
            <h2>已保存的签名：</h2>
            <img src="{{  $savedSignature }}" alt="{{ __('messages.signature') }}" class=" max-h-[200px]">
        </div>
    @else
        <h2>{{ __('messages.signature_prompt') }}</h2>
        <canvas 
            id="signature-pad" 
            height="200"
            class="bg-white border border-gray-300 w-full h-[200px] px-4 py-2"
            style="touch-action: none;"
        >
        </canvas>
    @endif
    <input type="hidden" wire:model="signatureData">
    <div class="mt-3 flex justify-end gap-2">
        <button 
            type="button" 
            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 md:px-6 rounded shadow text-sm md:text-base"
            onclick="clearSignature()"
        >
            {{ __('messages.clear_signature') }}
        </button>
        <button 
            type="button" 
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 md:px-6 rounded shadow text-sm md:text-base"
            onclick="saveCurrentSignature()"
        >
            {{ __('messages.save_signature') }}
        </button>
        
    </div>
    
    <!-- 显示消息 -->
    @if(session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    @push('scripts')
    <script>
        var signaturePad;

        // 等待 Livewire 组件完全加载后初始化
        document.addEventListener('livewire:navigated', function () {
            console.log('Livewire navigated event fired');
            setTimeout(initializeSignaturePad, 100); // 延迟初始化以确保DOM完全加载
        });
        
        // 为兼容旧版本 Livewire
        document.addEventListener('livewire:load', function () {
            console.log('Livewire load event fired');
            setTimeout(initializeSignaturePad, 100); // 延迟初始化以确保DOM完全加载
        });
        
        // 监听Livewire更新事件，以便在组件更新后重新初始化
        document.addEventListener('livewire:update', function () {
            setTimeout(initializeSignaturePad, 150);
        });
        
        function initializeSignaturePad() {
            var signatureContainer = document.getElementById('signature-pad');
            
            if (typeof SmoothSignature !== 'undefined' && signatureContainer) {
                // 如果已经有签名板实例，先销毁它
                if (signaturePad) {
                    try {
                        signaturePad.clear();
                    } catch(e) {
                        console.warn('Error clearing signature pad:', e);
                    }
                    signaturePad = null;
                }
                
                try {
                    // 重新创建签名板实例
                    signaturePad = new SmoothSignature(signatureContainer, {
                        penColor: 'black',
                        backgroundColor: 'white',
                        throttle: 16,
                        minWidth: 1,
                        maxWidth: 3
                    });
                    console.log('Signature pad initialized successfully');
                } catch(e) {
                    console.error('Error initializing signature pad:', e);
                }
            } else {
                console.log('Could not initialize signature pad');
                console.log('- SmoothSignature defined:', typeof SmoothSignature !== 'undefined');
                console.log('- Container exists:', !!signatureContainer);
            }
        }

        function clearSignature() {
            if (signaturePad) {
                try {
                    console.log('Clearing signature pad');
                    signaturePad.clear();
                } catch(e) {
                    console.error('Error clearing signature pad:', e);
                }
                
                // 清空隐藏字段
                @this.set('signatureData', '');
                @this.set('savedSignature', '');
                
                console.log('Signature pad cleared and ready for new signature');
            } else {
                console.log('No signature pad to clear');
                // 如果签名板还没初始化，尝试初始化它
                initializeSignaturePad();
            }
            
            // 确保签名板总是可用
            setTimeout(() => {
                initializeSignaturePad();
            }, 50);
        }

        // 确保在每次Livewire更新后重新初始化（如果需要）
        document.addEventListener('livewire:update', function () {
            setTimeout(() => {
                initializeSignaturePad();
            }, 100);
        });

        // 保存签名的方法
        function saveCurrentSignature() {
            console.log('Save signature called');
            if (signaturePad && !signaturePad.isEmpty()) {
                const dataUrl = signaturePad.toDataURL('image/png');
                @this.set('signatureData', dataUrl);
                @this.call('saveSignature', {{ $this->memberId }});
                console.log('Signature saved');
            } else {
                console.log('Signature is empty or signature pad not available');
            }
        }
    </script>
    @endpush
</div>