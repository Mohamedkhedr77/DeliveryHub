<?php

namespace App\Filament\Driver\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('product_name')
                    ->label('Product'),

                TextColumn::make('customer_phone')
                    ->label('Phone'),

                TextColumn::make('governorate.name')
                    ->label('Governorate'),

                TextColumn::make('city'),

                TextColumn::make('total_price')
                    ->money('EGP'),

                TextColumn::make('weight')
                    ->suffix(' kg'),
            ])
            
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('accept')
                    ->label('Accept')
                    ->color('success')
                    ->action(fn ($record) => $record->update([
                        'status_id' => 2,
                    ])),

                Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->action(fn ($record) => $record->update([
                        'status_id' => 6,
                    ])),
            ]);
    }
}