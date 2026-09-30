<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Hospital';

    public static function canViewAny(): bool { return auth()->user()?->can('manage doctors') || auth()->user()?->hasRole('doctor'); }
    public static function canCreate(): bool  { return auth()->user()?->can('manage doctors') ?? false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Profile')->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('department_id')->relationship('department', 'name')->required(),
                Forms\Components\FileUpload::make('photo')->image()->imageEditor()->directory('doctors')->avatar(),
                Forms\Components\TextInput::make('designation'),
                Forms\Components\TextInput::make('qualifications'),
                Forms\Components\TextInput::make('specialization'),
                Forms\Components\TextInput::make('experience_years')->numeric(),
                Forms\Components\TextInput::make('registration_no'),
                Forms\Components\TextInput::make('consultation_fee')->numeric(),
                Forms\Components\Toggle::make('video_consult'),
                Forms\Components\Toggle::make('is_featured'),
                Forms\Components\Toggle::make('status')->default(true),
                Forms\Components\RichEditor::make('bio')->columnSpanFull(),
            ])->columns(3),
            Forms\Components\Section::make('Weekly Schedule')->schema([
                Forms\Components\Repeater::make('schedules')->relationship('schedules')->schema([
                    Forms\Components\Select::make('day_of_week')->options([
                        0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
                        4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
                    ])->required(),
                    Forms\Components\TimePicker::make('start_time')->required()->default('09:00'),
                    Forms\Components\TimePicker::make('end_time')->required()->default('17:00'),
                    Forms\Components\TextInput::make('slot_duration_override')->numeric()->placeholder('hospital default'),
                    Forms\Components\TextInput::make('max_per_slot')->numeric()->default(1),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ])->columns(6),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('photo')->circular(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('department.name'),
            Tables\Columns\TextColumn::make('consultation_fee'),
            Tables\Columns\IconColumn::make('is_featured')->boolean(),
            Tables\Columns\IconColumn::make('status')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
