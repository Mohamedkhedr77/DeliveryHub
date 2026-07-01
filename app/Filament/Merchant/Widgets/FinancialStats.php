<?php

namespace App\Filament\Merchant\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $merchantId = auth()->id();

        $orders = Order::where('merchant_id', $merchantId);

        $totalOrders = $orders->count();

        $totalValue = (clone $orders)->sum('order_value');

        $shippingCost = (clone $orders)
            ->get()
            ->sum(fn ($order) => $order->total_price - $order->order_value);

        $averageOrderValue = $totalOrders
            ? $totalValue / $totalOrders
            : 0;

        return [
            Stat::make('إجمالي الأوردرات', $totalOrders)
                ->description('عدد الأوردرات الكلي')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make(
                'إجمالي قيمة الأوردرات',
                number_format($totalValue, 2) . ' ج.م'
            )
                ->description('إجمالي قيمة المبيعات')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make(
                'إجمالي تكلفة الشحن',
                number_format($shippingCost, 2) . ' ج.م'
            )
                ->description('إجمالي تكاليف الشحن')
                ->icon('heroicon-o-truck')
                ->color('warning'),

            Stat::make(
                'متوسط قيمة الأوردر',
                number_format($averageOrderValue, 2) . ' ج.م'
            )
                ->description('متوسط قيمة كل أوردر')
                ->icon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}