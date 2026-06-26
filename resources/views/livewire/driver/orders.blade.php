<?php

use App\Models\Order;
use App\Models\Status;
use App\Models\UndeliverableReason;
use App\Models\RejectionReason;
use App\Models\OrderStatusLog;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new #[Layout('layouts.app')] class extends Component
{
    public $activeTab = 'available';

    public $showUndeliverableModal = false;
    public $selectedOrderId = null;
    public $undeliverableReasonId = null;
    public $undeliverableCustomReason = '';

    public function getAvailableOrdersProperty()
    {
        $assignedStatus = Status::where('name', 'Assigned')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->where('status_id', $assignedStatus?->id)
            ->latest()
            ->get();
    }

    public function getActiveOrdersProperty()
    {
        $outForDeliveryStatus = Status::where('name', 'Out for Delivery')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->where('status_id', $outForDeliveryStatus?->id)
            ->latest()
            ->get();
    }

    public function getHistoryOrdersProperty()
    {
        $deliveredStatus = Status::where('name', 'Delivered')->first();
        $returnedStatus = Status::where('name', 'Returned')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->whereIn('status_id', [$deliveredStatus?->id, $returnedStatus?->id])
            ->latest()
            ->get();
    }

    public function acceptOrder($orderId)
    {
        $outForDeliveryStatus = Status::where('name', 'Out for Delivery')->first();
        $order = Order::findOrFail($orderId);

        $order->update(['status_id' => $outForDeliveryStatus->id]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $outForDeliveryStatus->id,
            'changed_by' => auth()->id(),
            'notes' => 'Driver accepted the order',
        ]);
    }

    public function rejectOrder($orderId)
    {
        $pendingStatus = Status::where('name', 'Pending')->first();
        $order = Order::findOrFail($orderId);

        RejectionReason::create([
            'order_id' => $order->id,
            'type' => 'driver_rejection',
            'driver_id' => auth()->id(),
            'reason' => 'Driver rejected the order',
        ]);

        $order->update([
            'status_id' => $pendingStatus->id,
            'driver_id' => null,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $pendingStatus->id,
            'changed_by' => auth()->id(),
            'notes' => 'Driver rejected the order - returned to pending',
        ]);
    }

    public function markDelivered($orderId)
    {
        $deliveredStatus = Status::where('name', 'Delivered')->first();
        $order = Order::findOrFail($orderId);

        $order->update(['status_id' => $deliveredStatus->id]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $deliveredStatus->id,
            'changed_by' => auth()->id(),
            'notes' => 'Delivery completed successfully',
        ]);
    }

    public function openUndeliverableModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->undeliverableReasonId = null;
        $this->undeliverableCustomReason = '';
        $this->showUndeliverableModal = true;
    }

    public function confirmUndeliverable()
    {
        $this->validate([
            'undeliverableReasonId' => 'required_without:undeliverableCustomReason',
            'undeliverableCustomReason' => 'required_without:undeliverableReasonId',
        ]);

        $returnedStatus = Status::where('name', 'Returned')->first();
        $order = Order::findOrFail($this->selectedOrderId);

        $reasonText = $this->undeliverableCustomReason;
        if ($this->undeliverableReasonId) {
            $reason = UndeliverableReason::find($this->undeliverableReasonId);
            $reasonText = $reason?->name ?? $this->undeliverableCustomReason;
        }

        RejectionReason::create([
            'order_id' => $order->id,
            'type' => 'delivery_failure',
            'driver_id' => auth()->id(),
            'reason' => $reasonText,
        ]);

        $order->update(['status_id' => $returnedStatus->id]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $returnedStatus->id,
            'changed_by' => auth()->id(),
            'notes' => 'Could not deliver: ' . $reasonText,
        ]);

        $this->showUndeliverableModal = false;
        $this->selectedOrderId = null;
        $this->undeliverableReasonId = null;
        $this->undeliverableCustomReason = '';
    }

    public function getUndeliverableReasonsProperty()
    {
        return UndeliverableReason::all();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
}; ?>

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
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا يوجد سجل توصيل</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Undeliverable Modal --}}
        @if ($showUndeliverableModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-100">سبب عدم التوصيل</h3>

                    <div class="space-y-3">
                        @foreach ($this->undeliverableReasons as $reason)
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                                <input type="radio" wire:model="undeliverableReasonId" value="{{ $reason->id }}" class="me-3">
                                <span class="dark:text-gray-200">{{ $reason->name }}</span>
                            </label>
                        @endforeach

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">أو اكتب سبباً آخر</label>
                            <textarea wire:model="undeliverableCustomReason" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"></textarea>
                            @error('undeliverableCustomReason') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            @error('undeliverableReasonId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
