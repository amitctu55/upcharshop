<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use Filament\Widgets\ChartWidget;

class DepartmentDistributionChart extends ChartWidget
{
    protected static ?string $heading = '🩺 Specialties & Clinical Coverage';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'lg' => 1,
    ];

    protected function getData(): array
    {
        $departments = Department::withCount('doctors')->where('status', true)->get();

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
            $labels = ['General Medicine'];
            $data = [1];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Specialist Doctors',
                    'data' => $data,
                    'backgroundColor' => array_slice($palette, 0, count($labels)),
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
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
