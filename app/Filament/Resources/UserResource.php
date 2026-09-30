<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Doctor;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Administration';

    public static function canViewAny(): bool { return auth()->user()?->can('manage users') ?? false; }
    public static function canCreate(): bool  { return auth()->user()?->can('manage users') ?? false; }

    public static function getEloquentQuery(): Builder
    {
        $q = parent::getEloquentQuery();
        return auth()->user()->isSuperAdmin() ? $q : $q->where('hospital_id', auth()->user()->hospital_id);
    }

    public static function form(Form $form): Form
    {
        $assignable = auth()->user()?->isSuperAdmin()
            ? Role::pluck('name', 'name')
            : Role::whereIn('name', ['doctor', 'receptionist', 'content_editor'])->pluck('name', 'name');

        return $form->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')->password()
                ->required(fn (?User $record) => $record === null)
                ->dehydrated(fn (?string $state) => filled($state)),
            Forms\Components\Select::make('hospital_id')->relationship('hospital', 'name')
                ->visible(fn () => auth()->user()->isSuperAdmin()),
            Forms\Components\Select::make('doctor_id')
                ->options(fn () => Doctor::pluck('name', 'id'))
                ->label('Linked doctor profile')->helperText('For doctor logins — restricts them to their own appointments'),
            Forms\Components\Select::make('roles')->multiple()->options($assignable)->required(),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('roles.name')->badge(),
            Tables\Columns\TextColumn::make('hospital.name')->visible(fn () => auth()->user()->isSuperAdmin()),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
