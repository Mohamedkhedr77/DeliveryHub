<?php

namespace App\Filament\Driver\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;

class MyOrders extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $slug = 'my-orders';

    protected static ?string $navigationLabel = 'My Orders';

    public static function getNavigationIcon(): ?string
{
    return 'heroicon-o-clipboard-document-list';
}

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.driver.pages.my-orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('driver_id', auth()->id())
                    ->whereIn('status_id', [2, 3])
            )
            ->columns([
                Tables\Columns\TextColumn::make('customer_name'),
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('status.name')->badge(),
                Tables\Columns\TextColumn::make('total_price')->money('EGP'),
            ])
            ->recordActions([
    Action::make('updateStatus')
        ->label('Update Status')
        ->form([
            Select::make('status_id')
                ->label('Status')
                ->options([
                    2 => 'Assigned',
                    3 => 'Out for Delivery',
                    4 => 'Delivered',
                    5 => 'Returned',
                ])
                ->required(),
        ])
        ->action(function (Order $record, array $data) {
            $record->update([
                'status_id' => $data['status_id'],
            ]);
        }),
]);
            
    }
}