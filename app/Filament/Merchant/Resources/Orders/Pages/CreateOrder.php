<?php

namespace App\Filament\Merchant\Resources\Orders\Pages;

use App\Filament\Merchant\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
