<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Property;

class PropertyStatusChart extends ChartWidget
{
    protected ?string $heading = 'Property Status';
    protected ?string $pollingInterval = '10s';


    protected function getData(): array
    {
        $data = Property::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
