<?php

namespace App\Filament\Resources\SendbillResource\Pages;

use App\Filament\Resources\SendbillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSendbill extends EditRecord
{
    protected static string $resource = SendbillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
