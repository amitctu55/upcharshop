<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;

class AppointmentsChart extends ChartWidget
{
    protected static ?string $heading = '📈 Appointment Volume Trend';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = [
        'default' => 'full',
        'lg' => 2,
    ];

    protected function getData(): array
    {
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('D, M j');
            $data[] = Appointment::whereDate('appointment_date', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Booked',
                    'data' => $data,
                    'fill' => true,
                    'borderColor' => '#0d9488',
                    'backgroundColor' => 'rgba(13, 148, 136, 0.15)',
                    'pointBackgroundColor' => '#0d9488',
                    'pointBorderColor' => '#ffffff',
                    'pointHoverRadius' => 6,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
