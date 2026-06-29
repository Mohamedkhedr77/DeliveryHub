<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">سبب تعذر التوصيل</h3>
        <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                <input type="radio" wire:model="selectedReason" value="العنوان خطأ" class="text-blue-600">
                <span class="text-gray-700 dark:text-gray-300">العنوان خطأ</span>
            </label>
            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                <input type="radio" wire:model="selectedReason" value="رفض الاستلام" class="text-blue-600">
                <span class="text-gray-700 dark:text-gray-300">رفض الاستلام</span>
            </label>
            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                <input type="radio" wire:model="selectedReason" value="تعذر الوصول للعميل" class="text-blue-600">
                <span class="text-gray-700 dark:text-gray-300">تعذر الوصول للعميل</span>
            </label>
        </div>
        @error('selectedReason')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
        <div class="flex items-center gap-3 mt-6">
            <button wire:click="confirmRejection"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition disabled:opacity-50">
                تأكيد
            </button>
            <button wire:click="cancelRejection"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                إلغاء
            </button>
        </div>
    </div>
</div>
