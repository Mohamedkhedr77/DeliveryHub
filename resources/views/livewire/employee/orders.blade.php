<?php

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use App\Models\OrderStatusLog;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public $activeTab = 'pending';

    public $showAssignModal = false;
    public $selectedOrderId = null;
    public $selectedDriverId = null;

    public function getPendingOrdersProperty()
    {
        $pendingStatus = Status::where('name', 'Pending')->first();
        return Order::with(['merchant', 'governorate'])
            ->where('status_id', $pendingStatus?->id)
            ->latest()
            ->get();
    }

    public function getDriverRejectedOrdersProperty()
    {
        $pendingStatus = Status::where('name', 'Pending')->first();
        return Order::with(['merchant', 'governorate', 'rejectionReasons.driver'])
            ->where('status_id', $pendingStatus?->id)
            ->whereHas('rejectionReasons', function ($q) {
                $q->where('type', 'driver_rejection');
            })
            ->latest()
            ->get();
    }

    public function getActiveDeliveriesProperty()
    {
        $assignedStatus = Status::where('name', 'Assigned')->first();
        $outForDeliveryStatus = Status::where('name', 'Out for Delivery')->first();
        return Order::with(['merchant', 'governorate', 'driver', 'status'])
            ->whereIn('status_id', [$assignedStatus?->id, $outForDeliveryStatus?->id])
            ->latest()
            ->get();
    }

    public function getCompletedOrdersProperty()
    {
        $deliveredStatus = Status::where('name', 'Delivered')->first();
        $returnedStatus = Status::where('name', 'Returned')->first();
        return Order::with(['merchant', 'governorate', 'driver', 'status'])
            ->whereIn('status_id', [$deliveredStatus?->id, $returnedStatus?->id])
            ->latest()
            ->get();
    }

    public function openAssignModal($orderId)
    {
        $this->selectedOrderId = $orderId;
        $this->selectedDriverId = null;
        $this->showAssignModal = true;
    }

    public function assignDriver()
    {
        $this->validate([
            'selectedDriverId' => 'required|exists:users,id',
        ]);

        $assignedStatus = Status::where('name', 'Assigned')->first();
        $order = Order::findOrFail($this->selectedOrderId);

        $order->update([
            'driver_id' => $this->selectedDriverId,
            'status_id' => $assignedStatus->id,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $assignedStatus->id,
            'changed_by' => auth()->id(),
            'notes' => 'Order assigned to driver',
        ]);

        $this->showAssignModal = false;
        $this->selectedOrderId = null;
        $this->selectedDriverId = null;
    }

    public function getDriversProperty()
    {
        return User::role('driver')->get();
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
                    <button wire:click="switchTab('pending')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'pending' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        طلبات جديدة ({{ $this->pendingOrders->count() }})
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="switchTab('rejected')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'rejected' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        طلبات مرفوضة من الدليفري ({{ $this->driverRejectedOrders->count() }})
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="switchTab('active')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'active' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        التوصيلات الحالية ({{ $this->activeDeliveries->count() }})
                    </button>
                </li>
                <li class="me-2">
                    <button wire:click="switchTab('completed')" class="inline-block p-4 border-b-2 rounded-t-lg {{ $activeTab === 'completed' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300' }}">
                        المكتملة ({{ $this->completedOrders->count() }})
                    </button>
                </li>
            </ul>
        </div>

        {{-- Pending Orders --}}
        @if ($activeTab === 'pending')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">الطلبات الجديدة (بانتظار التعيين)</h3>

                    @forelse ($this->pendingOrders as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">رقم العميل</p>
                                    <p class="font-medium" dir="ltr">{{ $order->customer_phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">المحافظة</p>
                                    <p class="font-medium">{{ $order->governorate?->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">التاجر</p>
                                    <p class="font-medium">{{ $order->merchant?->name }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button wire:click="openAssignModal({{ $order->id }})" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    تعيين دليفري
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد طلبات جديدة</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Driver Rejected Orders --}}
        @if ($activeTab === 'rejected')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">الطلبات المرفوضة من الدليفري</h3>

                    @forelse ($this->driverRejectedOrders as $order)
                        @php
                            $rejection = $order->rejectionReasons()->where('type', 'driver_rejection')->latest()->first();
                        @endphp
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600 border-red-300 dark:border-red-700">
                            <div class="flex items-start justify-between">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 flex-1">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                        <p class="font-medium">{{ $order->customer_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">رقم العميل</p>
                                        <p class="font-medium" dir="ltr">{{ $order->customer_phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">المحافظة</p>
                                        <p class="font-medium">{{ $order->governorate?->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">التاجر</p>
                                        <p class="font-medium">{{ $order->merchant?->name }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($rejection)
                                <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <p class="text-sm text-red-600 dark:text-red-400">
                                        <span class="font-semibold">رفض من: </span>{{ $rejection->driver?->name }}
                                        <span class="mx-2">|</span>
                                        <span class="font-semibold">تاريخ الرفض: </span>{{ $rejection->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                            @endif
                            <div class="mt-4">
                                <button wire:click="openAssignModal({{ $order->id }})" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    إعادة تعيين دليفري
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد طلبات مرفوضة</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Active Deliveries --}}
        @if ($activeTab === 'active')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">التوصيلات الحالية</h3>

                    @forelse ($this->activeDeliveries as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">الدليفري</p>
                                    <p class="font-medium">{{ $order->driver?->name ?? 'غير معين' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                                    <span class="px-2 py-1 text-xs rounded {{ $order->status?->name === 'Assigned' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $order->status?->name === 'Assigned' ? 'بانتظار القبول' : 'جاري التوصيل' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العنوان</p>
                                    <p class="font-medium">{{ $order->address }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد توصيلات حالية</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Completed Orders --}}
        @if ($activeTab === 'completed')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">الطلبات المكتملة</h3>

                    @forelse ($this->completedOrders as $order)
                        <div class="border rounded-lg p-4 mb-4 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">العميل</p>
                                    <p class="font-medium">{{ $order->customer_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">الدليفري</p>
                                    <p class="font-medium">{{ $order->driver?->name ?? 'غير معين' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                                    <span class="px-2 py-1 text-xs rounded {{ $order->status?->name === 'Delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $order->status?->name === 'Delivered' ? 'تم التوصيل' : 'مرتجع' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">التاريخ</p>
                                    <p class="font-medium">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">لا توجد طلبات مكتملة</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Assign Driver Modal --}}
        @if ($showAssignModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-100">تعيين دليفري للطلب</h3>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اختر الدليفري</label>
                        <select wire:model="selectedDriverId" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                            <option value="">-- اختر دليفري --</option>
                            @foreach ($this->drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name }} ({{ $driver->email }})</option>
                            @endforeach
                        </select>
                        @error('selectedDriverId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button wire:click="$set('showAssignModal', false)" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                            إلغاء
                        </button>
                        <button wire:click="assignDriver" wire:loading.attr="disabled" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition disabled:opacity-50">
                            تعيين
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
