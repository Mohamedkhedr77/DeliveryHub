<?php

namespace App\Filament\Resources\Orders\Schemas;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\Governorate;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('merchant_id')
                    ->label('Merchant')
                    ->options(
                        User::role('merchant')->pluck('name', 'id')->toArray()
                                 )   
                    ->searchable()
                    ->required(),
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('customer_phone')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
    

                Select::make('governorate_id')
                    ->options(
                        Governorate::pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->required(),

                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required(),
                TextInput::make('total_price')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
