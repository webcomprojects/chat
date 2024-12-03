<?php

namespace App\Filament\Resources\InfobillResource\Pages;

use App\Filament\Resources\InfobillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfobill extends EditRecord
{
    protected static string $resource = InfobillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
