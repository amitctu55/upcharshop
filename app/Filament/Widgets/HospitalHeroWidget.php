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

        $isSuperAdmin = $user && (method_exists($user, 'hasRole') && $user->hasRole('super_admin') || is_null($user->hospital_id));

        $totalHospitals = Hospital::count();
        $totalAppointments = Appointment::count();

        if ($hospital) {
            $todayAppointments = Appointment::where('hospital_id', $hospital->id)->whereDate('appointment_date', today())->count();
            $pendingAppointments = Appointment::where('hospital_id', $hospital->id)->where('status', 'pending')->count();
            $activeDoctors = Doctor::where('hospital_id', $hospital->id)->where('status', true)->count();
            $departmentsCount = \App\Models\Department::where('hospital_id', $hospital->id)->where('status', true)->count();
            $inquiriesCount = \App\Models\Inquiry::where('hospital_id', $hospital->id)->where('is_read', false)->count();
        } else {
            $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();
            $activeDoctors = Doctor::where('status', true)->count();
            $departmentsCount = \App\Models\Department::where('status', true)->count();
            $inquiriesCount = \App\Models\Inquiry::where('is_read', false)->count();
        }

        $featuredHospitals = Hospital::select(['id', 'name', 'slug', 'city', 'primary_color'])->take(6)->get();

        return [
            'user' => $user,
            'hospital' => $hospital,
            'isSuperAdmin' => $isSuperAdmin,
            'totalHospitals' => $totalHospitals,
            'totalAppointments' => $totalAppointments,
            'todayAppointments' => $todayAppointments,
            'pendingAppointments' => $pendingAppointments,
            'activeDoctors' => $activeDoctors,
            'departmentsCount' => $departmentsCount,
            'inquiriesCount' => $inquiriesCount,
            'featuredHospitals' => $featuredHospitals,
        ];
    }
}
