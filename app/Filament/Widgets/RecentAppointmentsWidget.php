<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentAppointmentsWidget extends BaseWidget
{
    protected static ?string $heading = '⚡ Live Bookings & Front Desk Stream';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()->with(['doctor', 'department'])->latest()->limit(7)
            )
            ->columns([
                Tables\Columns\TextColumn::make('reference_code')
                    ->label('Reference')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('patient_name')
                    ->label('Patient')
                    ->description(fn (Appointment $record): string => $record->phone ?? '')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->icon('heroicon-m-user-circle')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Date & Slot')
                    ->date('M j, Y')
                    ->description(fn (Appointment $record): string => $record->slot_time ?? '')
                    ->sortable(),

                Tables\Columns\TextColumn::make('visit_type')
                    ->label('Visit')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'info',
                        'followup' => 'success',
                        'video' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('token_no')
                    ->label('Token')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => $state ? "#{$state}" : '—'),

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
                    }),
                Tables\Actions\Action::make('view')
                    ->label('Manage')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Appointment $record): string => "/admin/appointments/{$record->id}/edit"),
            ]);
    }
}
