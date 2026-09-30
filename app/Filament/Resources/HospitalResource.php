<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HospitalResource\Pages;
use App\Models\Hospital;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HospitalResource extends Resource
{
    protected static ?string $model = Hospital::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Platform';

    public static function canViewAny(): bool { return auth()->user()?->hasRole('super_admin') ?? false; }
    public static function canCreate(): bool   { return auth()->user()?->hasRole('super_admin') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Hospital')->tabs([
                Forms\Components\Tabs\Tab::make('Identity')->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->helperText('Subdomain: slug.yourdomain.com'),
                    Forms\Components\TextInput::make('custom_domain')->helperText('Optional: client\'s own domain'),
                    Forms\Components\TextInput::make('tagline'),
                    Forms\Components\FileUpload::make('logo')->image()->imageEditor()->directory('branding'),
                    Forms\Components\FileUpload::make('favicon')->image()->directory('branding'),
                    Forms\Components\ColorPicker::make('primary_color'),
                    Forms\Components\ColorPicker::make('secondary_color'),
                    Forms\Components\TextInput::make('font_heading'),
                    Forms\Components\TextInput::make('font_body'),
                ])->columns(2),
                Forms\Components\Tabs\Tab::make('Contact')->schema([
                    Forms\Components\TextInput::make('phone'),
                    Forms\Components\TextInput::make('phone_2'),
                    Forms\Components\TextInput::make('emergency_phone'),
                    Forms\Components\TextInput::make('email'),
                    Forms\Components\TextInput::make('whatsapp'),
                    Forms\Components\Textarea::make('address')->rows(2),
                    Forms\Components\TextInput::make('city'),
                    Forms\Components\Textarea::make('map_embed')->rows(2)->label('Google Maps embed iframe'),
                    Forms\Components\KeyValue::make('social_links'),
                    Forms\Components\KeyValue::make('working_hours'),
                ])->columns(2),
                Forms\Components\Tabs\Tab::make('Booking Rules')->schema([
                    Forms\Components\TextInput::make('appointment_settings.slot_duration')->numeric()->default(15)->suffix('min'),
                    Forms\Components\Toggle::make('appointment_settings.auto_confirm'),
                    Forms\Components\TextInput::make('appointment_settings.advance_days')->numeric()->default(30),
                ])->columns(3),
                Forms\Components\Tabs\Tab::make('SEO & Status')->schema([
                    Forms\Components\TextInput::make('seo.title'),
                    Forms\Components\Textarea::make('seo.description')->rows(2),
                    Forms\Components\Select::make('status')->options(['active' => 'Active', 'suspended' => 'Suspended', 'maintenance' => 'Maintenance'])->default('active'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('slug'),
            Tables\Columns\TextColumn::make('city'),
            Tables\Columns\TextColumn::make('doctors_count')->counts('doctors')->label('Doctors'),
            Tables\Columns\TextColumn::make('users_count')->counts('users')->label('Staff'),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn ($state) => ['active' => 'success', 'suspended' => 'danger', 'maintenance' => 'warning'][$state] ?? 'gray'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHospitals::route('/'),
            'create' => Pages\CreateHospital::route('/create'),
            'edit' => Pages\EditHospital::route('/{record}/edit'),
        ];
    }
}
