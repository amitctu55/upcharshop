<?php

namespace App\Filament\Widgets;

use App\Http\Middleware\ResolveHospital;
use App\Models\Appointment;
use App\Models\Hospital;
use Filament\Widgets\ChartWidget;

class AppointmentsChart extends ChartWidget
{
    protected static ?string $heading = '📈 Patient Flow & Booking Trajectory';
    protected static ?string $description = 'Daily appointment admissions across general & emergency departments';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'lg' => 2,
    ];

    public ?string $filter = '14';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Last 7 Days',
            '14' => 'Last 14 Days',
            '30' => 'Last 30 Days',
        ];
    }

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

        $query = $hospital ? Appointment::where('hospital_id', $hospital->id) : Appointment::query();

        $days = (int) ($this->filter ?? 14);
        $labels = [];
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = today()->subDays($i);
            // Compact non-overlapping date format
            $labels[] = $date->format('M j');
            $data[] = (clone $query)->whereDate('appointment_date', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Registered',
                    'data' => $data,
                    'fill' => true,
                    'borderColor' => '#0d9488',
                    'backgroundColor' => 'rgba(13, 148, 136, 0.12)',
                    'pointBackgroundColor' => '#0d9488',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'autoSkip' => true,
                        'maxTicksLimit' => 8,
                        'maxRotation' => 0,
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'min' => 0,
                    'suggestedMax' => 5,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                        'font' => [
                            'size' => 11,
                        ],
                    ],
                    'grid' => [
                        'color' => 'rgba(226, 232, 240, 0.6)',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
