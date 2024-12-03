<?php

namespace App\Filament\Resources\InfobillResource\Pages;

use App\Filament\Resources\InfobillResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ElectricityBill extends Page
{
    use InteractsWithRecord;

    protected static string $resource = InfobillResource::class;

    protected static string $view = 'filament.resources.infobill-resource.pages.electricity-bill';

    protected static ?string $title = 'خرید برق بهینه';


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

}
