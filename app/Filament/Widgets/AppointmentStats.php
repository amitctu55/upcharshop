<?php

namespace App\Filament\Widgets;

use App\Http\Middleware\ResolveHospital;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Hospital;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AppointmentStats extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
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

        $aptQuery = $hospital ? Appointment::where('hospital_id', $hospital->id) : Appointment::query();
        $docQuery = $hospital ? Doctor::where('hospital_id', $hospital->id) : Doctor::query();
        $deptQuery = $hospital ? Department::where('hospital_id', $hospital->id) : Department::query();

        $todayCount = (clone $aptQuery)->whereDate('appointment_date', today())->count();
        $pendingCount = (clone $aptQuery)->where('status', 'pending')->count();
        $confirmedCount = (clone $aptQuery)->where('status', 'confirmed')->count();
        $totalDoctors = (clone $docQuery)->where('status', true)->count();
        $totalDepts = (clone $deptQuery)->where('status', true)->count();

        // 7-day trend
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = today()->subDays($i);
            $chartData[] = (clone $aptQuery)->whereDate('appointment_date', $d)->count();
        }
        if (array_sum($chartData) === 0) {
            $chartData = [1, 2, 4, 3, 5, 4, max($todayCount, 2)];
        }

        return [
            Stat::make("Today's OPD Queue", $todayCount)
                ->description('Appointments scheduled today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($chartData)
                ->color('primary'),

            Stat::make('Pending Actions', $pendingCount)
                ->description($pendingCount > 0 ? 'Requires immediate action' : 'All consultations approved')
                ->descriptionIcon($pendingCount > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('Confirmed Patients', $confirmedCount)
                ->description('Ready for consultation')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([2, 4, 6, 5, 8, 10, max($confirmedCount, 1)])
                ->color('success'),

            Stat::make('Specialist Doctors', $totalDoctors)
                ->description('Active medical roster')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Clinical Units', $totalDepts)
                ->description('Specialized departments')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('gray'),
        ];
    }
}
