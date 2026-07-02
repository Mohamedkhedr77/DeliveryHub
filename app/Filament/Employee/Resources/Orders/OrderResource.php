<?php

namespace App\Filament\Employee\Resources\Orders;

use App\Filament\Employee\Resources\Orders\Pages\CreateOrder;
use App\Filament\Employee\Resources\Orders\Pages\EditOrder;
use App\Filament\Employee\Resources\Orders\Pages\ListOrders;
use App\Filament\Employee\Resources\Orders\Schemas\OrderForm;
use App\Filament\Employee\Resources\Orders\Tables\OrdersTable;
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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
        ];
    }

    // 🛠️ تعديل دالة الاستعلام لتتوافق مع أرقام الـ IDs اللي جاية من الكروت
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $status = request('status');

        // لو باعتين حالة الانتظار (1) بنميز بين الجديد والـ waiting بناءً على وجود الكارت اللي اتداس
        if ($status == 1) {
            // هنا بنشوف هل جاي من كارت "New Orders" ولا "Waiting Driver"
            // الكارت الأول باعت status=1 (جديد ملوش سواق)، والتاني ممكن نميزه أو نخليه يقرا الـ driver_id
            if (request('type') === 'new') {
                $query->where('status_id', 1)->whereNull('driver_id');
            } elseif (request('type') === 'waiting') {
                $query->where('status_id', 1)->whereNotNull('driver_id');
            } else {
                $query->where('status_id', 1);
            }
        } 
        // باقي الحالات (شحن، تم الاستلام، ملغي، مرتجع) بتقرأ الـ ID المبعوت مباشرة
        elseif (request()->filled('status')) {
            $query->where('status_id', $status);
        }

        return $query;
    }
}