<div class="py-12" dir="rtl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Tabs --}}
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li class="me-2">
                    <button wire:click="switchTab('available')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'available' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        الطلبات المتاحة ({{ $this->availableOrders->count() }})
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="switchTab('active')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'active' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        التوصيلات الحالية ({{ $this->activeOrders->count() }})
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="switchTab('history')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'history' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        سجل التوصيل
                    </button>
                </li>
            </ul>
        </div>

        @php $totalOrders = $this->availableOrders->count() + $this->activeOrders->count() + $this->historyOrders->count(); @endphp

        @if($totalOrders === 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-16 w-16 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="text-xl font-semibold">لا يوجد شحنات فى الوقت الحالى</p>
                </div>
            </div>
        @else

        {{-- Available Orders --}}
        @if ($activeTab === 'available')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">الطلبات المتاحة للتوصيل</h3>

                    @forelse ($this->availableOrders as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">رقم العميل</p>
                                    <p class="font-medium" dir="ltr">{{ $order->customer_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العنوان</p>
                                    <p class="font-medium">{{ $order->address }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">المحافظة</p>
                                    <p class="font-medium">{{ $order->governorate?->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">المدينة</p>
                                    <p class="font-medium">{{ $order->city }}</p>
                                </div>
                                @if($order->total_price)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">السعر</p>
                                    <p class="font-medium">{{ number_format($order->total_price, 2) }} ج.م</p>
                                </div>
                                @endif
                            </div>
                            @if($order->notes)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">ملاحظات</p>
                                    <p class="text-sm">{{ $order->notes }}</p>
                                </div>
                            @endif
                            <div class="mt-4 flex gap-3">
                                <button wire:click="acceptOrder({{ $order->id }})" wire:loading.attr="disabled" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50">
                                    قبول الطلب
                                </button>
                                <button wire:click="rejectOrder({{ $order->id }})" wire:loading.attr="disabled" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition disabled:opacity-50">
                                    رفض الطلب
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد طلبات متاحة حالياً</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Active Orders --}}
        @if ($activeTab === 'active')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">التوصيلات الحالية</h3>

                    @forelse ($this->activeOrders as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">رقم العميل</p>
                                    <p class="font-medium" dir="ltr">{{ $order->customer_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العنوان</p>
                                    <p class="font-medium">{{ $order->address }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">المحافظة</p>
                                    <p class="font-medium">{{ $order->governorate?->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">المدينة</p>
                                    <p class="font-medium">{{ $order->city }}</p>
                                </div>
                                @if($order->total_price)
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">السعر</p>
                                    <p class="font-medium">{{ number_format($order->total_price, 2) }} ج.م</p>
                                </div>
                                @endif
                            </div>
                            <div class="mt-4 flex gap-3">
                                <button wire:click="markDelivered({{ $order->id }})" wire:loading.attr="disabled" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:opacity-50">
                                    تم التوصيل
                                </button>
                                <button wire:click="openUndeliverableModal({{ $order->id }})" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                                    تعذر التوصيل
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد توصيلات حالية</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- History --}}
        @if ($activeTab === 'history')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">سجل التوصيل</h3>

                    @forelse ($this->historyOrders as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                                    <span class="px-2 py-1 text-xs rounded {{ $order->status?->name === 'Delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $order->status?->name === 'Delivered' ? 'تم التوصيل' : 'تعذر التوصيل' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ التوصيل</p>
                                    <p class="font-medium">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                            @if($order->status?->name === 'Returned')
                                @php
                                    $failureReason = $order->rejectionReasons()->where('type', 'delivery_failure')->first();
                                @endphp
                                @if($failureReason)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">سبب عدم التوصيل</p>
                                        <p class="text-sm text-red-600">{{ $failureReason->reason }}</p>
                                    </div>
                                @endif
                            @endif
                            <button wire:click="toggleDetails({{ $order->id }})" class="mt-3 text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ $expandedOrderId === $order->id ? 'إخفاء التفاصيل ▲' : 'عرض التفاصيل ▼' }}
                            </button>

                            @if($expandedOrderId === $order->id)
                                @php
                                    $detailOrder = \App\Models\Order::with(['merchant', 'governorate', 'rejectionReasons', 'statusLogs.status', 'statusLogs.changedBy'])->find($order->id);
                                    $statusLabels = [
                                        'Pending' => 'تم إنشاء الطلب',
                                        'Assigned' => 'تم تعيين دليفري',
                                        'Out for Delivery' => 'تم قبول الطلب من الدليفري',
                                        'Delivered' => 'تم التوصيل بنجاح',
                                        'Returned' => 'تعذر التوصيل',
                                        'Cancelled' => 'تم الإلغاء',
                                    ];
                                    $logs = $detailOrder->statusLogs()->orderBy('created_at')->get();
                                    $failureReasonDetail = $detailOrder->rejectionReasons()->where('type', 'delivery_failure')->first();
                                @endphp
                                <div class="mt-3 border-t pt-3 dark:border-gray-600">
                                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                                        <div><span class="text-gray-500">العميل: </span><span class="dark:text-gray-200">{{ $order->customer_name }}</span></div>
                                        <div><span class="text-gray-500">رقم الهاتف: </span><span class="dark:text-gray-200" dir="ltr">{{ $order->customer_phone }}</span></div>
                                        <div class="col-span-2"><span class="text-gray-500">العنوان: </span><span class="dark:text-gray-200">{{ $order->address }}</span></div>
                                        <div><span class="text-gray-500">المحافظة: </span><span class="dark:text-gray-200">{{ $order->governorate?->name }}</span></div>
                                        <div><span class="text-gray-500">المدينة: </span><span class="dark:text-gray-200">{{ $order->city }}</span></div>
                                        @if($order->total_price)
                                        <div><span class="text-gray-500">السعر: </span><span class="dark:text-gray-200">{{ number_format($order->total_price, 2) }} ج.م</span></div>
                                        @endif
                                        @if($order->notes)
                                        <div class="col-span-2"><span class="text-gray-500">ملاحظات: </span><span class="dark:text-gray-200">{{ $order->notes }}</span></div>
                                        @endif
                                        @if($failureReasonDetail)
                                        <div class="col-span-2"><span class="text-gray-500">سبب الرفض: </span><span class="text-red-600">{{ $failureReasonDetail->reason }}</span></div>
                                        @endif
                                    </div>
                                    <h5 class="text-sm font-semibold mb-2 dark:text-gray-200">خط سير التوصيل</h5>
                                    @forelse ($logs as $log)
                                        <div class="flex gap-2 pb-3 relative">
                                            <div class="flex flex-col items-center">
                                                <div class="w-2.5 h-2.5 rounded-full {{ $loop->last ? 'bg-indigo-500' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                                                @if(!$loop->last)
                                                    <div class="w-0.5 h-full bg-gray-300 dark:bg-gray-600 absolute top-2.5"></div>
                                                @endif
                                            </div>
                                            <div class="flex-1 -mt-1">
                                                <p class="text-xs font-medium dark:text-gray-200">{{ $statusLabels[$log->status?->name] ?? $log->status?->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $log->created_at->format('Y-m-d H:i') }}</p>
                                                @if($log->notes)
                                                    <p class="text-xs text-gray-400">{{ $log->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-500">لا يوجد سجل</p>
                                    @endforelse
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا يوجد سجل توصيل</p>
                    @endforelse
                </div>
            </div>
        @endif
        @endif

        {{-- Undeliverable Modal --}}
        @if ($showUndeliverableModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-100">سبب عدم التوصيل</h3>

                    <div class="space-y-3">
                        @foreach ($this->undeliverableReasons as $reason)
                            <label wire:key="reason-{{ $reason->id }}" class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                                <input type="radio" wire:model.live="undeliverableReasonId" value="{{ $reason->id }}" class="me-3">
                                <span class="dark:text-gray-200">{{ $reason->name }}</span>
                            </label>
                        @endforeach

                        @if($this->isRefusalReason())
                            <div class="mt-2 p-3 border border-red-300 rounded-lg dark:border-red-700">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">سبب رفض العميل</label>
                                <textarea wire:model="customerRefusalReason" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" placeholder="اكتب سبب رفض العميل..."></textarea>
                            </div>
                        @endif

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">أو اكتب سبباً آخر</label>
                            <textarea wire:model="undeliverableCustomReason" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"></textarea>
                            @error('undeliverableCustomReason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('undeliverableReasonId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ملاحظات</label>
                            <textarea wire:model="undeliverableNotes" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" placeholder="أي ملاحظات إضافية..."></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-3">
                        <button wire:click="$set('showUndeliverableModal', false)" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                            إلغاء
                        </button>
                        <button wire:click="confirmUndeliverable" wire:loading.attr="disabled" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition disabled:opacity-50">
                            تأكيد
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
