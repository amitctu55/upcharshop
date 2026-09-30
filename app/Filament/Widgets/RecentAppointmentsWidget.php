<?php

namespace App\Filament\Widgets;

use App\Http\Middleware\ResolveHospital;
use App\Models\Appointment;
use App\Models\Hospital;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentAppointmentsWidget extends BaseWidget
{
    protected static ?string $heading = '⚡ Live Bookings & Front Desk Stream';
    protected static ?string $description = 'Real-time patient registrations, token assignments, and consultation queue';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $host = request()->getHost();
        $subdomain = (new ResolveHospital)->subdomain($host);

        $hospital = null;
        if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
            $hospital = Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
        }
        if (!$hospital && $user && $user->hospital_id) {
            $hospital = $user->hospital;
        }

        $query = Appointment::query()
            ->with(['doctor', 'department', 'hospital'])
            ->when($hospital, fn ($q) => $q->where('hospital_id', $hospital->id))
            ->latest()
            ->limit(10);

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('reference_code')
                    ->label('Ref')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Reference code copied')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Patient & Contact')
                    ->description(fn (Appointment $record): string => trim(($record->phone ?? '') . ' • ' . ($record->email ?? '')))
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Assigned Specialist')
                    ->icon('heroicon-m-user-circle')
                    ->description(fn (Appointment $record): string => $record->department?->name ?? 'General Medicine')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Schedule')
                    ->date('D, M j, Y')
                    ->description(fn (Appointment $record): string => $record->slot_time ? '⏰ ' . $record->slot_time : 'Standard Slot')
                    ->sortable(),

                Tables\Columns\TextColumn::make('visit_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'info',
                        'followup' => 'success',
                        'video' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'new' => 'New Patient',
                        'followup' => 'Follow-up',
                        'video' => 'Tele-consult',
                        default => ucfirst($state ?? 'Standard'),
                    }),

                Tables\Columns\TextColumn::make('token_no')
                    ->label('Token')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => $state ? "#{$state}" : 'Auto'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmed' => 'success',
                        'pending'   => 'warning',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default     => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->button()
                    ->size('xs')
                    ->visible(fn (Appointment $record): bool => $record->status === 'pending')
                    ->action(function (Appointment $record) {
                        $record->update(['status' => 'confirmed']);
                        Notification::make()
                            ->title('Appointment Confirmed')
                            ->body("Booking #{$record->reference_code} for {$record->patient_name} has been confirmed.")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('call')
                    ->icon('heroicon-m-phone')
                    ->color('info')
                    ->iconButton()
                    ->tooltip('Call Patient')
                    ->visible(fn (Appointment $record): bool => !empty($record->phone))
                    ->url(fn (Appointment $record): string => "tel:{$record->phone}"),

                Tables\Actions\Action::make('view')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->iconButton()
                    ->tooltip('Manage Appointment')
                    ->url(fn (Appointment $record): string => "/admin/appointments/{$record->id}/edit"),
            ])
            ->emptyStateHeading('No Appointments Recorded Yet')
            ->emptyStateDescription('Start registering new OPD patients or launch public web booking for your hospital.')
            ->emptyStateIcon('heroicon-o-calendar-days')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Book New Appointment')
                    ->url('/admin/appointments/create')
                    ->icon('heroicon-m-plus')
                    ->button()
                    ->color('primary'),
            ]);
    }
}
