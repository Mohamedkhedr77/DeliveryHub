<?php
namespace App\Filament\Resources\Orders\Schemas;
use App\Models\User;
use App\Models\Governorate;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;
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
                    ->afterStateUpdated(fn (Get $get, Set $set) =>
                        self::updatePrice($get, $set)
                    )
                    ->required(),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Select::make('driver_id')
                    ->label('Driver')
                    ->options(
                        User::role('driver')
                            ->with('governorate') // مهم لو العلاقة موجودة
                            ->get()
                            ->mapWithKeys(function ($driver) {
                                return [
                                    $driver->id => $driver->name .
                                        ' - ' .
                                        ($driver->governorate?->name ?? 'No Governorate')
                                ];
                            })
                            ->toArray()
                    )
                    ->searchable()
                    ->preload(),
                Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required(),
                TextInput::make('order_value')
                    ->label('قيمة الأوردر')
                    ->numeric()
                    ->prefix('EGP')
                    ->live()
                    ->afterStateUpdated(fn (Get $get, Set $set) =>
                        self::updatePrice($get, $set)
                    )
                    ->required(),
                TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg')
                    ->live()
                    ->helperText('لو الوزن اكبر من  3 كجم يتم إضافة 15 جنيه لكل كجم زيادة')
                    ->afterStateUpdated(fn (Get $get, Set $set) =>
                        self::updatePrice($get, $set)
                    )
                    ->required(),
                Checkbox::make('is_village')
                    ->label('Delivery to a village')
                    ->live()
                    ->helperText('إضافة 30 جنيه للقرى')
                    ->afterStateUpdated(fn (Get $get, Set $set) =>
                        self::updatePrice($get, $set)
                    ),
                TextInput::make('total_price')
                    ->label('الإجمالي')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),
                Textarea::make('price_breakdown')
                    ->label('تفاصيل السعر')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
    private static function updatePrice(Get $get, Set $set): void
    {
        $governorate = Governorate::find($get('governorate_id'));
        $baseShipping = $governorate?->shipping_price ?? 0;
        $orderValue = (float) $get('order_value');
        $weight = (float) $get('weight');
        $total = $orderValue + $baseShipping;
        $breakdown = [
            "Order Value" => $orderValue,
            "Shipping" => $baseShipping,
        ];
        if ($weight > 3) {
            $extra = ($weight - 3) * 15;
            $breakdown["Weight Price"] = $extra;
            $total += $extra;
        }
        if ($get('is_village')) {
            $breakdown["سعر القريه"] = 30;
            $total += 30;
        }
        $breakdown["total price"] = $total;
        $set('total_price', $total);
        $set('price_breakdown', collect($breakdown)
            ->map(fn ($v, $k) => "{$k}: {$v}")
            ->implode("\n")
        );
    }
}