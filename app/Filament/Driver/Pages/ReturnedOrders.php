<?php

namespace App\Filament\Driver\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class ReturnedOrders extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'returned-orders';

    protected static ?string $navigationLabel = 'Returned Orders';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-arrow-uturn-left';
    }

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.driver.pages.returned-orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('driver_id', auth()->id())
                    ->where('status_id', 5) // المرتجعات
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer'),

                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Phone'),

                Tables\Columns\TextColumn::make('city'),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('EGP'),
            ]);
    }
}