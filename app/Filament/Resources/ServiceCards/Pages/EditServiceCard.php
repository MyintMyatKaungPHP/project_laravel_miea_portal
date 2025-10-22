<?php

namespace App\Filament\Resources\ServiceCards\Pages;

use App\Filament\Resources\ServiceCards\ServiceCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditServiceCard extends EditRecord
{
    protected static string $resource = ServiceCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
