<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MerchantFinancialStats extends BaseWidget
{
    protected function getStats(): array
    {
        $merchantId = Auth::id();

        $orders = Order::where('merchant_id', $merchantId);

        return [
            Stat::make('إجمالي الأوردرات', $orders->count()),

            Stat::make('إجمالي قيمة الأوردرات', $orders->sum('total_price') . ' EGP'),

            Stat::make('إجمالي تكلفة الشحن', $orders->sum('shipping_cost') . ' EGP'),

            Stat::make(
                'صافي المبيعات',
                ($orders->sum('total_price') - $orders->sum('shipping_cost')) . ' EGP'
            ),
        ];
    }
}