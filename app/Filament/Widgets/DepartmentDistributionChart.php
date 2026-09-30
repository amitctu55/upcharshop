<?php

namespace App\Filament\Widgets;

use App\Http\Middleware\ResolveHospital;
use App\Models\Department;
use App\Models\Hospital;
use Filament\Widgets\ChartWidget;

class DepartmentDistributionChart extends ChartWidget
{
    protected static ?string $heading = '🩺 Specialties & Clinical Roster';
    protected static ?string $description = 'Distribution of specialist doctors across active hospital departments';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getData(): array
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

        $query = $hospital ? Department::where('hospital_id', $hospital->id) : Department::query();
        $departments = $query->withCount('doctors')->where('status', true)->take(7)->get();

        $labels = [];
        $data = [];
        $palette = [
            '#0d9488', '#0284c7', '#6366f1', '#8b5cf6', 
            '#ec4899', '#f59e0b', '#10b981', '#3b82f6',
        ];

        foreach ($departments as $dept) {
            $labels[] = $dept->name;
            $data[] = max($dept->doctors_count, 1);
        }

        if (empty($labels)) {
            $labels = ['General Medicine', 'Cardiology', 'Pediatrics'];
            $data = [3, 2, 2];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Specialist Doctors',
                    'data' => $data,
                    'backgroundColor' => array_slice($palette, 0, count($labels)),
                    'borderWidth' => 3,
                    'borderColor' => '#ffffff',
                    'hoverOffset' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
