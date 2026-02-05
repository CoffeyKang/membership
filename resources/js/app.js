import './bootstrap';

// 引入 smooth-signature 的 JS
import SmoothSignature from 'smooth-signature';

// 把它挂到 window 上，方便在 Blade 中使用
window.SmoothSignature = SmoothSignature;

// 确保 Livewire 组件更新后重新初始化样式
document.addEventListener('DOMContentLoaded', function () {
    if (window.Livewire) {
        Livewire.hook('morph.updated', () => {
            // 可以在这里添加需要在每次 Livewire 更新后执行的代码
        });
    }
});
