{{-- resources/views/components/snackbar.blade.php --}}
<div 
    x-data="{ show: false, message: '', type: 'info' }"
    x-init="
        @if(session('success'))
            show = true; message = '{{ session('success') }}'; type = 'success';
        @elseif(session('error'))
            show = true; message = '{{ session('error') }}'; type = 'error';
        @elseif(session('warning'))
            show = true; message = '{{ session('warning') }}'; type = 'warning';
        @endif

        if (show) {
            setTimeout(() => show = false, 4000);
        }
    "
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-4 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 translate-y-4"
>
    <div 
        class="px-4 py-3 rounded-md shadow-lg flex items-center space-x-3 w-[350px] justify-between"
        :class="{
            'bg-green-600 text-white': type === 'success',
            'bg-red-600 text-white': type === 'error',
            'bg-yellow-600 text-white': type === 'warning',
            'bg-gray-800 text-white': type === 'info'
        }"
    >
        <span x-text="message" class="text-sm font-medium"></span>
        <button @click="show = false" class="text-white opacity-70 hover:opacity-100">✖</button>
    </div>
</div>
