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
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-300">قيمة الطلب: <strong class="text-green-600">{{ number_format($order->order_value, 2) }} EGP</strong></span>
                        <span class="text-gray-700 dark:text-gray-300">الإجمالي: <strong class="text-blue-600">{{ number_format($order->total_price, 2) }} EGP</strong></span>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                4 => 'bg-green-100 text-green-800',
                                5 => 'bg-red-100 text-red-800',
                            ];
                            $statusLabels = [
                                4 => 'تم التوصيل',
                                5 => 'تعذر التوصيل',
                            ];
                        @endphp
                        <span class="text-xs font-medium px-2 py-0.5 rounded {{ $statusColors[$order->status_id] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusLabels[$order->status_id] ?? $order->status?->name }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg">لا توجد طلبات مكتملة بعد</p>
        </div>
    @endforelse
</div>
