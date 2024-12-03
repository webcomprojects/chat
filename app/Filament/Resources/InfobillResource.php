<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfobillResource\Pages;
use App\Filament\Resources\InfobillResource\RelationManagers;
use App\Models\Infobill;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InfobillResource extends Resource
{
    protected static ?string $model = Infobill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'خرید برق بهینه';

    protected static ?string $label = 'قبض';

    protected static ?string $modelLabel = 'قبض';

    protected static ?string $pluralLabel = 'قبوض ارسالی';

    protected static ?string $navigationGroup  = 'تحلیل قبض';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('name')
                        ->label('نام و نام خانوادگی')
                        ->required()
                        ->maxLength(50)
                        ->validationMessages([
                            'required' => 'این فیلد الزامی است',
                        ]),

                    TextInput::make('job')
                        ->label('سمت شما')
                        ->maxLength(50),

                    TextInput::make('phone')
                        ->label('شماره تماس')
                        ->required()
                        ->maxLength(50)
                        ->validationMessages([
                            'required' => 'این فیلد الزامی است',
                        ]),

                    TextInput::make('economic_unit')
                        ->label('نام واحد اقتصادی')
                        ->required()
                        ->maxLength(50)
                        ->validationMessages([
                            'required' => 'این فیلد الزامی است',
                        ]),

                    TextInput::make('ceo_name')
                        ->label('نام مدیرعامل')
                        ->maxLength(50),

                    TextInput::make('contractual_power')
                        ->label('قدرت قراردادی')
                        ->maxLength(50),

                    Radio::make('made16_status')
                        ->label('آیا مشمول ماده ۱۶ می شوید؟')
                        ->inline()
                        ->options([
                            'yes' => 'بله',
                            'no' => 'خیر',
                        ])
                        ->default('yes'),

                    TextInput::make('Two_way_electricity_rate')
                        ->label('نرخ خرید برق دو جانبه')
                        ->numeric()
                        ->hint('به ریال وارد کنید')
                        ->maxLength(50),

                    Fieldset::make('شرح مصارف')
                        ->schema([
                            Fieldset::make('میان باری')
                                ->schema([
                                    TextInput::make('middle_load_meter_consumption')->numeric()
                                        ->label('مصرف کنتور (کیلووات / ساعت)')
                                        ->maxLength(50),
                                    TextInput::make('middle_load_allocation_coefficient')->numeric()
                                        ->label('ضریب تخصیص بار پایه (TOU)')
                                        ->maxLength(50),
                                    TextInput::make('middle_load_electricity_supply_rate')->numeric()
                                        ->label('نرخ تامین برق پشتیبان در آخرین قبض')
                                        ->maxLength(50),
                                ])->columns(3),
                            Fieldset::make('اوج بار')
                                ->schema([
                                    TextInput::make('peak_load_meter_consumption')->numeric()
                                        ->label('مصرف کنتور (کیلووات / ساعت)')
                                        ->maxLength(50),
                                    TextInput::make('peak_load_allocation_coefficient')->numeric()
                                        ->label('ضریب تخصیص بار پایه (TOU)')
                                        ->maxLength(50),
                                    TextInput::make('peak_load_electricity_supply_rate')->numeric()
                                        ->label('نرخ تامین برق پشتیبان در آخرین قبض')
                                        ->maxLength(50),
                                ])->columns(3),
                            Fieldset::make('کم باری')
                                ->schema([
                                    TextInput::make('low_load_meter_consumption')->numeric()
                                        ->label('مصرف کنتور (کیلووات / ساعت)')
                                        ->maxLength(50),
                                    TextInput::make('low_load_allocation_coefficient')->numeric()
                                        ->label('ضریب تخصیص بار پایه (TOU)')
                                        ->maxLength(50),
                                    TextInput::make('low_load_electricity_supply_rate')->numeric()
                                        ->label('نرخ تامین برق پشتیبان در آخرین قبض')
                                        ->maxLength(50),
                                ])->columns(3)
                        ]),

                    Select::make('status')
                        ->label('وضعیت')
                        ->options([
                            'در حال بررسی' => 'در حال بررسی',
                            'تایید شده' => 'تایید شده',
                            'رد شده' => 'رد شده',
                        ])
                        ->default('در حال بررسی')
                        ->visible(auth()->user()->can('change_status_sendbill')),
                    Hidden::make('user_id')->default(Auth::id())

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->can('access_all_bill_sendbill') ? Infobill::orderby('created_at', 'desc') : Infobill::where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('user.email')->label('نام کاربری')->searchable()->sortable(),
                TextColumn::make('name')->label('نام و نام خانوادگی')->searchable()->sortable(),
                TextColumn::make('job')->label('سمت')->searchable()->sortable(),
                TextColumn::make('phone')->label('شماره تماس')->searchable()->sortable(),
                TextColumn::make('economic_unit')->label('نام واحد اقتصادی')->searchable()->sortable(),
                TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'در حال بررسی' => 'warning',
                        'تایید شده' => 'success',
                        'رد شده' => 'danger',
                    })
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'در حال بررسی' => 'در حال بررسی',
                        'تایید شده' => 'تایید شده',
                        'رد شده' => 'رد شده',
                    ])->label('وضعیت')
            ])
            ->actions([
                Action::make('edit')
                    ->label('مشاهده تحلیل قبض')
                    ->color('info')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn($record): string => route('filament.admin.resources.infobills.bill', ['record' => $record->id])),
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->color('success'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'access_all_bill',
            'change_status',
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfobills::route('/'),
            'create' => Pages\CreateInfobill::route('/create'),
            'view' => Pages\ViewInfobill::route('/{record}'),
            'edit' => Pages\EditInfobill::route('/{record}/edit'),
            'bill' => Pages\ElectricityBill::route('/{record}/electricitybill'),
        ];
    }
}
