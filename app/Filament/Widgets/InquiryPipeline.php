<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Inquiry;

   class InquiryPipeline extends ChartWidget
   {
       protected ?string $heading = '📊 Inquiry Pipeline';
       protected ?string $pollingInterval = '10s';

       protected function getData(): array
       {
           $new = Inquiry::where('status', 'new')->count();
           $contacted = Inquiry::where('status', 'contacted')->count();
           $closed = Inquiry::where('status', 'closed')->count();

           return [
               'datasets' => [
                   [
                       'label' => 'Leads',
                       'data' => [$new, $contacted, $closed],
                   ],
               ],
               'labels' => ['New', 'Contacted', 'Closed'],
           ];
       }

    protected function getType(): string
    {
        return 'line';
    }
}
