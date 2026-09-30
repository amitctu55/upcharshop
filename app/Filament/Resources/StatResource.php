<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatResource\Pages;
use App\Models\Stat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatResource extends Resource
{
    protected static ?string $model = Stat::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Hospital Content';

    public static function canViewAny(): bool { return auth()->user()?->can('manage stats') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('value')->required()->placeholder('e.g. 15+, 25,000+'),
            Forms\Components\TextInput::make('icon'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('label')->searchable(),
            Tables\Columns\TextColumn::make('value')->weight('bold')->color('primary'),
            Tables\Columns\TextColumn::make('icon'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStats::route('/'),
            'create' => Pages\CreateStat::route('/create'),
            'edit' => Pages\EditStat::route('/{record}/edit'),
        ];
    }
}
