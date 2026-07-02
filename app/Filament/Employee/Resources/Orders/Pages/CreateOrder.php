<?php

namespace App\Filament\Employee\Resources\Orders\Pages;

use App\Filament\Employee\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}