<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Property;

class PropertyChart extends ChartWidget
{
    protected ?string $heading = 'Property Growth (Monthly)';
    protected ?string $pollingInterval = '10s';
    protected function getData(): array
    {
        $data = \App\Models\Property::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
               ->groupBy('month')
               ->pluck('total', 'month');

           return [
               'datasets' => [
                   [
                       'label' => 'Properties',
                       'data' => $data->values(),
                       'borderWidth' => 3,
                       'tension' => 0.4, // smooth curve
                   ],
               ],
               'labels' => $data->keys()->map(fn ($m) => "M$m"),
           ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
