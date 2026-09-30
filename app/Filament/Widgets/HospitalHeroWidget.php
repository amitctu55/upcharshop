<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Hospital;
use Filament\Widgets\Widget;

class HospitalHeroWidget extends Widget
{
    protected static string $view = 'filament.widgets.hospital-hero-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 1;

    public function getViewData(): array
    {
        $user = auth()->user();
        $host = request()->getHost();
        $subdomain = (new \App\Http\Middleware\ResolveHospital)->subdomain($host);

        $hospital = null;
        if ($subdomain !== '' && $subdomain !== 'localhost' && $subdomain !== $host) {
            $hospital = Hospital::where('slug', $subdomain)->orWhere('custom_domain', $host)->first();
        }
        if (!$hospital && $user && $user->hospital_id) {
            $hospital = $user->hospital;
        }

        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $activeDoctors = Doctor::where('status', true)->count();

        return [
            'user' => $user,
            'hospital' => $hospital,
            'todayAppointments' => $todayAppointments,
            'pendingAppointments' => $pendingAppointments,
            'activeDoctors' => $activeDoctors,
        ];
    }
}
