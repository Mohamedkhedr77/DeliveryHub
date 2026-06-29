<div class="space-y-4">
    @forelse ($orders as $order)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-start justify-between">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                        <span class="text-sm text-gray-500">{{ $order->customer_phone }}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-medium">العنوان:</span> {{ $order->address }}
                    </p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ $order->governorate?->name }}</span>
                        <span>{{ $order->city }}</span>
                        @if ($order->is_village)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded">قرية</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-300">قيمة الطلب: <strong class="text-green-600">{{ number_format($order->order_value, 2) }} EGP</strong></span>
                        <span class="text-gray-700 dark:text-gray-300">الإجمالي: <strong class="text-blue-600">{{ number_format($order->total_price, 2) }} EGP</strong></span>
                        <span class="text-gray-500">الوزن: {{ $order->weight }} kg</span>
                    </div>
                    @if ($order->notes)
                        <p class="text-sm text-gray-500 italic">ملاحظات: {{ $order->notes }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="acceptOrder({{ $order->id }})"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                        قبول
                    </button>
                    <button wire:click="rejectOrder({{ $order->id }})"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50">
                        رفض
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg">لا توجد طلبات جديدة حالياً</p>
        </div>
    @endforelse
</div>
