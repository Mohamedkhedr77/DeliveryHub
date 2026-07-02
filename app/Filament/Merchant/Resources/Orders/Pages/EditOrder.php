<?php

namespace App\Filament\Merchant\Resources\Orders\Pages;

use App\Filament\Merchant\Resources\Orders\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord; // 👇 تأكد إنها EditRecord مش ListRecords

class EditOrder extends EditRecord // 👇 غيرنا اسم الكلاس ليكون مطابق لاسم الفايل
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}