<?php

namespace App\Filament\Resources\Governorates\Pages;

use App\Filament\Resources\Governorates\GovernorateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGovernorate extends ViewRecord
{
    protected static string $resource = GovernorateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
