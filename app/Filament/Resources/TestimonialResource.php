<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Hospital Content';

    public static function canViewAny(): bool { return auth()->user()?->can('manage testimonials') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('patient_name')->required(),
            Forms\Components\FileUpload::make('photo')->image()->directory('testimonials'),
            Forms\Components\Select::make('rating')->options([
                1 => '1 Star', 2 => '2 Stars', 3 => '3 Stars', 4 => '4 Stars', 5 => '5 Stars'
            ])->default(5)->required(),
            Forms\Components\Select::make('department_id')->relationship('department', 'name'),
            Forms\Components\Textarea::make('text')->required()->columnSpanFull(),
            Forms\Components\Toggle::make('status')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('photo')->circular(),
            Tables\Columns\TextColumn::make('patient_name')->searchable(),
            Tables\Columns\TextColumn::make('rating')->badge()->color('warning'),
            Tables\Columns\TextColumn::make('department.name'),
            Tables\Columns\IconColumn::make('status')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
