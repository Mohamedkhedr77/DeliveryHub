<?php

namespace App\Filament\Resources\Orders\Schemas;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\Governorate;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;


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
                    ->options(Governorate::pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {

                        $governorate = Governorate::find($get('governorate_id'));

                        $price = $governorate?->shipping_price ?? 0;

                        $weight = (float) $get('weight');

                        if ($weight > 3) {
                            $price += ($weight - 3) * 15;
                        }

                        $set('total_price', $price);
                    })
                    ->required(),

                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required(),
                TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg')
                    ->live()
                    ->helperText('في حالة زيادة الوزن عن 3 كجم يتم إضافة 15 جنيه لكل كجم إضافي.')
                    ->afterStateUpdated(function (Get $get, Set $set) {

                        $governorate = Governorate::find($get('governorate_id'));

                        $price = $governorate?->shipping_price ?? 0;

                        $weight = (float) $get('weight');

                        if ($weight > 3) {
                            $price += ($weight - 3) * 15;
                        }

                        $set('total_price', $price);
                    })
                    ->required(),
                Checkbox::make('is_village')
                    ->label('Delivery to a village')
                    ->helperText('في حالة اختيار قرية، سيتم إضافة 30 جنيه إلى تكلفة الشحن.')
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {

                        $governorate = Governorate::find($get('governorate_id'));

                        $price = $governorate?->shipping_price ?? 0;

                        $weight = (float) $get('weight');

                        if ($weight > 3) {
                            $price += ($weight - 3) * 15;
                        }

                        if ($get('is_village')) {
                            $price += 30;
                        }

                        $set('total_price', $price);
                    }),
                TextInput::make('total_price')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
