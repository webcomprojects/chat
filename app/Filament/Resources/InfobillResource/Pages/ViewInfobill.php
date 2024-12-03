<?php

namespace App\Filament\Resources\InfobillResource\Pages;

use App\Filament\Resources\InfobillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInfobill extends ViewRecord
{
    protected static string $resource = InfobillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
