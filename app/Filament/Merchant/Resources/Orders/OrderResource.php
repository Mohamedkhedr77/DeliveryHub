<?php

namespace App\Filament\Merchant\Resources\Orders;

use App\Filament\Merchant\Resources\Orders\Pages\CreateOrder;
use App\Filament\Merchant\Resources\Orders\Pages\EditOrder;
use App\Filament\Merchant\Resources\Orders\Pages\ListOrders;
use App\Filament\Merchant\Resources\Orders\Schemas\OrderForm;
use App\Filament\Merchant\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'customer_name';

    // 👇 رجعنا الكود الأصلي النظيف وباصينا الـ $schema زي ما التيم مثبتها
    public static function form(Schema $schema): Schema
    {
         return OrderForm::configure($schema); 
         // 💡 ملاحظة: لو التيم كاتب السطر ده بشكل تاني (مثلاً OrderForm::make) سيبه زي ما كان عندهم بالظبط
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('merchant_id', auth()->id());
    }
}