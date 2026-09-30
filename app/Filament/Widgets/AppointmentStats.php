<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentStats extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $todayCount = Appointment::whereDate('appointment_date', today())->count();
        $pendingCount = Appointment::where('status', 'pending')->count();
        $confirmedCount = Appointment::where('status', 'confirmed')->count();
        $totalDoctors = Doctor::where('status', true)->count();
        $totalDepts = Department::where('status', true)->count();

        // Historical appointments sparkline (last 7 days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = today()->subDays($i);
            $chartData[] = Appointment::whereDate('appointment_date', $d)->count();
        }

        return [
            Stat::make("Today's Appointments", $todayCount)
                ->description('Scheduled for today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($chartData)
                ->color('primary'),

            Stat::make('Pending Confirmation', $pendingCount)
                ->description('Requires staff approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('Confirmed Patients', $confirmedCount)
                ->description('Ready for consultation')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([3, 5, 8, 6, 9, 12, max($confirmedCount, 1)])
                ->color('success'),

            Stat::make('Specialist Doctors', $totalDoctors)
                ->description('Active on duty')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Clinical Specialties', $totalDepts)
                ->description('Specialized departments')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('gray'),
        ];
    }
}
