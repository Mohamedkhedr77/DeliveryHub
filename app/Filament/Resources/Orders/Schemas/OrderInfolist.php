<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('merchant.name')
                    ->label('Merchant'),
                TextEntry::make('customer_name'),
                TextEntry::make('customer_phone'),
                TextEntry::make('address')
                    ->columnSpanFull(),
                TextEntry::make('governorate.name')
                    ->label('Governorate'),
            
                TextEntry::make('status.name')
                    ->label('Status'),
                TextEntry::make('total_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
