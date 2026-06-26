<?php

namespace App\Livewire\Driver;

use App\Models\Order;
use App\Models\Status;
use App\Models\UndeliverableReason;
use App\Models\RejectionReason;
use App\Models\OrderStatusLog;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;

#[Layout('layouts.app')]
class OrderBoard extends Component
{
    public string $activeTab = 'available';

    public bool $showUndeliverableModal = false;
    public ?int $selectedOrderId = null;
    public ?int $undeliverableReasonId = null;
    public string $undeliverableCustomReason = '';
    public string $undeliverableNotes = '';
    public string $customerRefusalReason = '';

    public ?int $expandedOrderId = null;

    #[Computed]
    public function availableOrders()
    {
        $assignedStatus = Status::where('name', 'Assigned')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->where('status_id', $assignedStatus?->id)
            ->latest()
            ->get();
    }

    #[Computed]
    public function activeOrders()
    {
        $outForDeliveryStatus = Status::where('name', 'Out for Delivery')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->where('status_id', $outForDeliveryStatus?->id)
            ->latest()
            ->get();
    }

    #[Computed]
    public function historyOrders()
    {
        $deliveredStatus = Status::where('name', 'Delivered')->first();
        $returnedStatus = Status::where('name', 'Returned')->first();
        return Order::with(['merchant', 'governorate', 'status'])
            ->where('driver_id', auth()->id())
            ->whereIn('status_id', [$deliveredStatus?->id, $returnedStatus?->id])
            ->latest()
            ->get();
    }

    public function isRefusalReason(): bool
    {
        if (!$this->undeliverableReasonId) return false;
        $reason = UndeliverableReason::find($this->undeliverableReasonId);
        return $reason && $reason->name === 'رفض العميل الاستلام';
    }

    #[Computed]
    public function undeliverableReasons()
    {
        return UndeliverableReason::all();
    }

    public function acceptOrder(int $orderId): void
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

    public function rejectOrder(int $orderId): void
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

    public function markDelivered(int $orderId): void
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

    public function openUndeliverableModal(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->undeliverableReasonId = null;
        $this->undeliverableCustomReason = '';
        $this->showUndeliverableModal = true;
    }

    public function confirmUndeliverable(): void
    {
        $this->validate([
            'undeliverableReasonId' => 'required_without:undeliverableCustomReason',
            'undeliverableCustomReason' => 'required_without:undeliverableReasonId',
        ]);

        $returnedStatus = Status::where('name', 'Returned')->first();
        $order = Order::findOrFail($this->selectedOrderId);

        $reasonText = $this->undeliverableCustomReason;
        $detailedReason = '';
        if ($this->undeliverableReasonId) {
            $reason = UndeliverableReason::find($this->undeliverableReasonId);
            $reasonText = $reason?->name ?? $this->undeliverableCustomReason;
            if ($reason?->name === 'رفض العميل الاستلام' && $this->customerRefusalReason) {
                $detailedReason = ' - سبب الرفض: ' . $this->customerRefusalReason;
            }
        }

        $finalReason = $reasonText . $detailedReason;
        $logNotes = 'Could not deliver: ' . $finalReason;
        if ($this->undeliverableNotes) {
            $logNotes .= ' | ملاحظات: ' . $this->undeliverableNotes;
        }

        RejectionReason::create([
            'order_id' => $order->id,
            'type' => 'delivery_failure',
            'driver_id' => auth()->id(),
            'reason' => $finalReason,
        ]);

        $order->update(['status_id' => $returnedStatus->id]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status_id' => $returnedStatus->id,
            'changed_by' => auth()->id(),
            'notes' => $logNotes,
        ]);

        $this->reset(['showUndeliverableModal', 'selectedOrderId', 'undeliverableReasonId', 'undeliverableCustomReason', 'undeliverableNotes', 'customerRefusalReason']);
    }

    public function toggleDetails(int $orderId): void
    {
        $this->expandedOrderId = $this->expandedOrderId === $orderId ? null : $orderId;
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.driver.order-board');
    }
}
