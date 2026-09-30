<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content';

    // HARD RULE: only hospital_admin & super_admin touch the gallery
    protected static function adminOnly(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'hospital_admin']) ?? false;
    }

    public static function canViewAny(): bool        { return static::adminOnly(); }
    public static function canCreate(): bool         { return static::adminOnly(); }
    public static function canEdit(Model $r): bool   { return static::adminOnly(); }
    public static function canDelete(Model $r): bool { return static::adminOnly(); }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')->image()->imageEditor()->directory('gallery')->required(),
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('alt_text')->required(),
            Forms\Components\Select::make('gallery_category_id')->relationship('category', 'name')->label('Category'),
            Forms\Components\TextInput::make('caption'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('status')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image'),
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('category.name'),
            Tables\Columns\IconColumn::make('status')->boolean(),
        ])->reorderable('sort_order')
          ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
