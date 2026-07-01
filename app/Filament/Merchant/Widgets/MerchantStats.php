<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Order;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class MerchantStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $merchant = Filament::auth()->user();

        // استعلام واحد سريع ونظيف
        $orderCounts = Order::where('merchant_id', $merchant->id)
            ->select('status_id', DB::raw('count(*) as count'))
            ->groupBy('status_id')
            ->pluck('count', 'status_id')
            ->toArray();

        // هنجيب رابط اللوحة الحالي تلقائياً (عشان نضمن إن اللينك ما يضربش مهما كان اسم الكلاس)
        $panelUrl = Filament::getCurrentPanel()->getUrl();

        return [
            Stat::make('Pending', $orderCounts[1] ?? 0)
                ->url($panelUrl . '/orders?status_id=1'),

            Stat::make('Assigned', $orderCounts[2] ?? 0)
                ->url($panelUrl . '/orders?status_id=2'),

            Stat::make('Out For Delivery', $orderCounts[3] ?? 0)
                ->url($panelUrl . '/orders?status_id=3'),

            Stat::make('Delivered', $orderCounts[4] ?? 0)
                ->url($panelUrl . '/orders?status_id=4'),

            Stat::make('Returned', $orderCounts[5] ?? 0)
                ->url($panelUrl . '/orders?status_id=5'),

            Stat::make('Cancelled', $orderCounts[6] ?? 0)
                ->url($panelUrl . '/orders?status_id=6'),
        ];
    }
}