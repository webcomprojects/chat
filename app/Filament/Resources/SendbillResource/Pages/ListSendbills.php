<?php

namespace App\Filament\Resources\SendbillResource\Pages;

use App\Filament\Resources\SendbillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSendbills extends ListRecords
{
    protected static string $resource = SendbillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
}
