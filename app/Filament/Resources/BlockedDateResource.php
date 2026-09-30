<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockedDateResource\Pages;
use App\Models\BlockedDate;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlockedDateResource extends Resource
{
    protected static ?string $model = BlockedDate::class;
    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';
    protected static ?string $navigationGroup = 'Hospital';

    public static function canViewAny(): bool { return auth()->user()?->can('manage schedules') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('date')->required(),
            Forms\Components\Select::make('doctor_id')
                ->options(fn () => Doctor::pluck('name', 'id'))
                ->helperText('Leave empty to block the entire hospital')
                ->label('Doctor (Optional)'),
            Forms\Components\TextInput::make('reason'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('date')->date()->sortable(),
            Tables\Columns\TextColumn::make('doctor.name')->label('Doctor')->placeholder('Entire Hospital')->badge(),
            Tables\Columns\TextColumn::make('reason'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlockedDates::route('/'),
            'create' => Pages\CreateBlockedDate::route('/create'),
            'edit' => Pages\EditBlockedDate::route('/{record}/edit'),
        ];
    }
}
