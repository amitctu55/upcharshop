<?php

namespace App\Filament\Widgets;

use App\Http\Middleware\ResolveHospital;
use App\Models\Hospital;
use App\Models\Inquiry;
use Filament\Widgets\Widget;

class HospitalOperationsWidget extends Widget
{
    protected static string $view = 'filament.widgets.hospital-operations-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 4;

    public function getViewData(): array
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

        $latestInquiries = Inquiry::query()
            ->when($hospital, fn ($q) => $q->where('hospital_id', $hospital->id))
            ->latest()
            ->take(3)
            ->get();

        return [
            'hospital' => $hospital,
            'user' => $user,
            'latestInquiries' => $latestInquiries,
        ];
    }
}
