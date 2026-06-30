<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Status;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrdersStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $stats = [];

        // إجمالي الأوردرات
        $stats[] = Stat::make('إجمالي الأوردرات', Order::count())
                ->description('كل الأوردرات')
                ->color('primary')
                ->url(route('filament.admin.resources.orders.index'));
            

        // كل الحالات
        foreach (Status::all() as $status) {

            $color = match (strtolower($status->name)) {
                'pending' => 'warning',
                'assigned' => 'info',
                'out for delivery' => 'primary',
                'delivered' => 'success',
                'returned' => 'gray',
                'cancelled' => 'danger',
                default => 'primary',
            };

            $stats[] = Stat::make(
                $status->name,
                Order::where('status_id', $status->id)->count()
            )
                ->color($color)
                ->url(route('filament.admin.resources.orders.index'). '?status=' . $status->id);
        }

        return $stats;
    }
}