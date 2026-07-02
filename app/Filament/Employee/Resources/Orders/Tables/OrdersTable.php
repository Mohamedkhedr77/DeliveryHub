<?php

namespace App\Filament\Employee\Resources\Orders\Tables;
use App\Models\User;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
    Tables\Columns\TextColumn::make('id')
        ->label('Order ID'),

    Tables\Columns\TextColumn::make('merchant.name')
        ->label('Merchant'),

    Tables\Columns\TextColumn::make('customer_name')
        ->label('Customer'),

    Tables\Columns\TextColumn::make('governorate.name')
        ->label('Governorate'),

    Tables\Columns\TextColumn::make('order_value')
        ->label('Order Value'),

    Tables\Columns\TextColumn::make('status.name')
        ->label('Status'),
    Tables\Columns\TextColumn::make('driver.name')
    ->label('Driver')
    ->default('Not Assigned'),
])
            ->filters([
    SelectFilter::make('status_id')
        ->label('Status')
        ->relationship('status', 'name'),
    SelectFilter::make('driver_id')
    ->label('Driver')
    ->options(
        User::role('driver')
            ->with('governorate')
            ->get()
            ->mapWithKeys(fn ($driver) => [
                $driver->id => $driver->name . ' - ' . ($driver->governorate->name ?? ''),
            ])
    )
])
            ->recordActions([
    Action::make('assignDriver')
    ->label('Assign Driver')
    ->icon('heroicon-o-truck')
    ->visible(fn ($record) =>
        ($record->status_id == 1 && is_null($record->driver_id))
        || $record->status_id == 6
    )
    ->form([
        Forms\Components\Select::make('driver_id')
            ->label('Driver')
            ->options(
    User::role('driver')
        ->with('governorate')
        ->get()
        ->mapWithKeys(function ($driver) {
            return [
                $driver->id => $driver->name . ' - ' . ($driver->governorate->name ?? 'No Governorate'),
            ];
        })
)
            ->searchable()
            ->required(),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'driver_id' => $data['driver_id'],
        ]);
    }),
    
])
            ->toolbarActions([
                //
            ]);
    }
}