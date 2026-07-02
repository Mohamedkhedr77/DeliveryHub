<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeOrderStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            // 1. New Orders
            Stat::make(
                'New Orders',
                Order::where('status_id', 1)
                    ->whereNull('driver_id')
                    ->count()
            )
            ->description('Pending Orders')
            ->icon('heroicon-o-shopping-bag')
            ->color('primary')
            ->url(url('/employee/orders?status=1&type=new')), // 👈 بناء الـ URL يدوي ومباشر

            // 2. Waiting Driver
            Stat::make(
                'Waiting Driver',
                Order::where('status_id', 1)
                    ->whereNotNull('driver_id')
                    ->count()
            )
            ->description('Waiting for Driver')
            ->icon('heroicon-o-clock')
            ->color('warning')
            ->url(url('/employee/orders?status=1&type=waiting')),

            // 3. In Delivery
            Stat::make('In Delivery', Order::where('status_id', 3)->count())
                ->description('Orders in Delivery')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->url(url('/employee/orders?status=3')),

            // 4. Delivered
            Stat::make('Delivered', Order::where('status_id', 4)->count())
                ->description('Delivered Orders')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->url(url('/employee/orders?status=4')),

            // 5. Cancelled
            Stat::make('Cancelled', Order::where('status_id', 6)->count())
                ->description('Cancelled Orders')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->url(url('/employee/orders?status=6')),

            // 6. Returned
            Stat::make('Returned', Order::where('status_id', 5)->count())
                ->description('Returned Orders')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('gray')
                ->url(url('/employee/orders?status=5')),

        ];
    }
}