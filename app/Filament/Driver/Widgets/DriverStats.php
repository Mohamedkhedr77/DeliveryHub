<?php

namespace App\Filament\Driver\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DriverStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $driverId = auth()->id();

        return [
            Stat::make(
                'Assigned',
                Order::where('driver_id', $driverId)
                    ->where('status_id', 2)
                    ->count()
            ),

            Stat::make(
                'Out For Delivery',
                Order::where('driver_id', $driverId)
                    ->where('status_id', 3)
                    ->count()
            ),

            Stat::make(
                'Delivered',
                Order::where('driver_id', $driverId)
                    ->where('status_id', 4)
                    ->count()
            ),

            Stat::make(
                'Returned',
                Order::where('driver_id', $driverId)
                    ->where('status_id', 5)
                    ->count()
            ),
        ];
    }
}