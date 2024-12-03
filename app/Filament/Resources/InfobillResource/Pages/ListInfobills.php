<?php

namespace App\Filament\Resources\InfobillResource\Pages;

use App\Filament\Resources\InfobillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfobills extends ListRecords
{
    protected static string $resource = InfobillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
