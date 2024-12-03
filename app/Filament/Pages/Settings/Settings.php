<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{
    public static function getNavigationLabel(): string
    {
        return 'تنظیمات';
    }

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('درصد ماده ۱۶')
                        ->schema([
                            TextInput::make('percent.include')->label('درصد میزان مشمول ماده 16 جهش تولید صنایع دانش بنیان')
                                ->required(),
                            TextInput::make('percent.not_include')->label('درصد میزان مصرف غیر مشمول')
                                ->required(),
                        ]),
                ]),
        ];
    }
}
