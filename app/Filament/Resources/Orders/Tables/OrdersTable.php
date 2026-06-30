<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\User;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('merchant.name')
                    ->label('Merchant'),
                TextColumn::make('driver.name')
                    ->label('Driver')
                    ->searchable(),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('customer_phone')
                    ->searchable(),
                TextColumn::make('governorate.name')
                    ->label('Governorate'),
                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label('Status'),
                TextColumn::make('total_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('weight')
                    ->label('Weight')
                    ->suffix(' kg')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                
            ])
            
            ->filters([
                SelectFilter::make('status')
    ->relationship('status', 'name')
    ->label('Status'),
                SelectFilter::make('driver_id')
                    ->label('Driver')
                    ->options(
                        User::role('driver')->pluck('name', 'id')
                    ),

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
