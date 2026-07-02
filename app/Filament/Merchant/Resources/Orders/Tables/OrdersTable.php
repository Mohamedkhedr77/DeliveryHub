<?php

namespace App\Filament\Merchant\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('driver.name')
                    ->label('Driver')
                    ->placeholder('Not Assigned'),      
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('product_name')
                    ->searchable(),
                TextColumn::make('customer_phone')
                    ->searchable(),
                TextColumn::make('governorate.name')
                    ->label('Governorate'),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('order_value')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('total_price')
                    ->money()
                    ->sortable(),
                IconColumn::make('is_village')
                    ->boolean(),
            ])
            ->modifyQueryUsing(function ($query) {
    if (request()->filled('status_id')) {
        $query->where('status_id', request('status_id'));
    }
})
            ->filters([
    SelectFilter::make('status_id')
        ->label('Status')
        ->options([
            1 => 'Pending',
            2 => 'Assigned',
            3 => 'Out For Delivery',
            4 => 'Delivered',
            5 => 'Returned',
            6 => 'Cancelled',
        ])
])
            ->recordUrl(null)
            ->recordActions([
                
                EditAction::make()
                ->visible(fn ($record) => $record->status_id == 1),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}