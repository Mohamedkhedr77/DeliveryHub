<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('merchant.name')
                    ->label('Merchant'),
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
<<<<<<< HEAD
=======
                TextColumn::make('weight')
                    ->label('Weight')
                    ->suffix(' kg')
                    ->sortable(),
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
<<<<<<< HEAD
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge(),
=======
                    ->toggleable(isToggledHiddenByDefault: true)
                
>>>>>>> ba502d374805e14a4bff87105c4a440161c171d5
            ])
            ->filters([
                //
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
