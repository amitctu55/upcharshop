<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Front Desk';

    public static function canViewAny(): bool  { return auth()->user()?->can('view appointments') ?? false; }
    public static function canCreate(): bool   { return auth()->user()?->can('create appointments') ?? false; }
    public static function canEdit(Model $r): bool { return auth()->user()?->can('update appointments') ?? false; }
    public static function canDelete(Model $r): bool { return auth()->user()?->can('manage all appointments') ?? false; }

    public static function getEloquentQuery(): Builder
    {
        $q = parent::getEloquentQuery()->with(['doctor', 'department']);
        if (auth()->user()->hasRole('doctor') && auth()->user()->doctor_id) {
            $q->where('doctor_id', auth()->user()->doctor_id);   // doctors see ONLY their own
        }
        return $q;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('patient_name')->required(),
            Forms\Components\TextInput::make('phone')->required(),
            Forms\Components\TextInput::make('email')->email(),
            Forms\Components\TextInput::make('age')->numeric(),
            Forms\Components\Select::make('gender')->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other']),
            Forms\Components\Select::make('department_id')->relationship('department', 'name')->required(),
            Forms\Components\Select::make('doctor_id')->relationship('doctor', 'name')->required(),
            Forms\Components\DatePicker::make('appointment_date')->required(),
            Forms\Components\TimePicker::make('slot_time')->required(),
            Forms\Components\Select::make('visit_type')->options(['new' => 'New', 'followup' => 'Follow-up', 'video' => 'Video'])->default('new'),
            Forms\Components\Select::make('status')->options(array_combine(Appointment::STATUSES, Appointment::STATUSES))->default('pending'),
            Forms\Components\Select::make('source')->options(['online' => 'Online', 'walkin' => 'Walk-in', 'phone' => 'Phone', 'admin' => 'Admin'])->default('admin'),
            Forms\Components\Textarea::make('notes')->rows(2),
            Forms\Components\Textarea::make('admin_notes')->rows(2)->visible(fn () => ! auth()->user()->hasRole('doctor')),
            Forms\Components\TextInput::make('token_no')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('reference_code')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('patient_name')->searchable(),
            Tables\Columns\TextColumn::make('doctor.name')->sortable(),
            Tables\Columns\TextColumn::make('appointment_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('slot_time'),
            Tables\Columns\TextColumn::make('token_no')->label('Token'),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn ($state) => [
                'pending' => 'warning', 'confirmed' => 'success', 'completed' => 'info',
                'cancelled' => 'danger', 'no_show' => 'gray',
            ][$state] ?? 'gray'),
        ])
        ->defaultSort('appointment_date', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('status')->options(array_combine(Appointment::STATUSES, Appointment::STATUSES)),
            Tables\Filters\Filter::make('today')->query(fn ($q) => $q->whereDate('appointment_date', today()))->toggle(),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
