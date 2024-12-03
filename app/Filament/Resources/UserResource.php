<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'کاربران';

    protected static ?string $label = 'کاربر';

    protected static ?string $modelLabel = 'کاربر';

    protected static ?string $pluralLabel = 'کاربران';

    protected static ?string $navigationGroup  = 'مدیریت کاربران';



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

                    TextInput::make('email')
                        ->label('آدرس ایمیل')
                        ->required()
                        ->email()
                        ->maxLength(255),

                    TextInput::make('password')
                        ->label('رمز عبور')
                        ->required(fn(string $context): bool => $context === 'create')
                        ->password()
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn($state) => Hash::make($state)),

                    TextInput::make('password_confirmation')
                        ->label('تایید رمز عبور')
                        ->required(fn(string $context): bool => $context === 'create')
                        ->password()
                        ->maxLength(255)
                        ->same('password')
                        ->validationMessages([
                            'same' => 'رمز عبور یکسان نیست'
                        ]),

                    Forms\Components\CheckboxList::make('roles')
                        ->label('نقش کاربری')
                        ->relationship('roles', 'name')
                        ->searchable(),




                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('نام و نام خانوادگی')->searchable()->sortable(),
                TextColumn::make('email')->label('آدرس ایمیل')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
