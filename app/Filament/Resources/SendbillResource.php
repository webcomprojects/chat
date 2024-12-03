<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SendbillResource\Pages;
use App\Filament\Resources\SendbillResource\RelationManagers;
use App\Models\Sendbill;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SendbillResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Sendbill::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'ارسال قبض';

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

                    Select::make('status')
                        ->label('وضعیت')
                        ->options([
                            'در حال بررسی' => 'در حال بررسی',
                            'تایید شده' => 'تایید شده',
                            'رد شده' => 'رد شده',
                        ])
                        ->visible(auth()->user()->can('change_status_sendbill')),

                    FileUpload::make('file')
                        ->label('بارگذاری فایل انرژی')
                        ->imageEditor()
                        ->imageEditorMode(2)
                        ->downloadable(),


                    Hidden::make('user_id')->default(Auth::id())

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(auth()->user()->can('access_all_bill_sendbill') ? Sendbill::orderby('created_at', 'desc') : Sendbill::where('user_id', Auth::id()))
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
                Tables\Actions\ViewAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSendbills::route('/'),
            'create' => Pages\CreateSendbill::route('/create'),
            'view' => Pages\ViewSendbill::route('/{record}'),
            'edit' => Pages\EditSendbill::route('/{record}/edit'),
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
}
