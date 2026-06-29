<?php

namespace App\Livewire\Driver;

use App\Models\Order;
use App\Models\OrderStatusLog;
use App\Models\RejectionReason;
use Livewire\Component;

class Dashboard extends Component
{
    public string $activeTab = 'new';
    public bool $showRejectionModal = false;
    public ?int $rejectionOrderId = null;
    public string $selectedReason = '';

    public function newOrders()
    {
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('status_id', 1)
            ->latest()
            ->get();
    }

    public function myOrders()
    {
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->whereIn('status_id', [3])
            ->latest()
            ->get();
    }

    public function completedOrders()
    {
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->whereIn('status_id', [4, 5])
            ->latest()
            ->get();
    }

    public function acceptOrder(int $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status_id' => 3,
            'driver_id' => auth()->id(),
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => 3,
            'changed_by' => auth()->id(),
            'notes' => 'تم قبول التوصيل بواسطة الكابتن',
        ]);

        $this->dispatch('order-updated');
    }

    public function rejectOrder(int $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status_id' => 2,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => 2,
            'changed_by' => auth()->id(),
            'notes' => 'تم رفض التوصيل بواسطة الكابتن',
        ]);

        $this->dispatch('order-updated');
    }

    public function markDelivered(int $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status_id' => 4,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => 4,
            'changed_by' => auth()->id(),
            'notes' => 'تم التوصيل بنجاح',
        ]);

        $this->dispatch('order-updated');
    }

    public function openRejectionModal(int $orderId): void
    {
        $this->rejectionOrderId = $orderId;
        $this->selectedReason = '';
        $this->showRejectionModal = true;
    }

    public function confirmRejection(): void
    {
        $this->validate([
            'selectedReason' => 'required|string',
        ]);

        $order = Order::findOrFail($this->rejectionOrderId);
        $order->update([
            'status_id' => 5,
        ]);

        RejectionReason::create([
            'order_id' => $order->id,
            'reason' => $this->selectedReason,
        ]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => 5,
            'changed_by' => auth()->id(),
            'notes' => 'تعذر التوصيل: ' . $this->selectedReason,
        ]);

        $this->showRejectionModal = false;
        $this->rejectionOrderId = null;
        $this->selectedReason = '';
        $this->dispatch('order-updated');
    }

    public function cancelRejection(): void
    {
        $this->showRejectionModal = false;
        $this->rejectionOrderId = null;
        $this->selectedReason = '';
    }

    public function render()
    {
        return view('livewire.driver.dashboard')
            ->layout('layouts.app');
    }
}
