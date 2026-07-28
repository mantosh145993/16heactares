<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Property;

class PropertyTypeChart extends ChartWidget
{
    protected ?string $heading = 'Property Chart';
    protected ?string $pollingInterval = '15s';


    protected function getData(): array
       {
           $data = Property::selectRaw('property_type, COUNT(*) as total')
               ->groupBy('property_type')
               ->pluck('total', 'property_type');

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
        return 'radar';
    }
}
