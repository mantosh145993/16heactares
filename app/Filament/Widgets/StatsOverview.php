<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Property;
use App\Models\User;
use App\Models\Inquiry;
use App\Models\Blog;

class StatsOverview extends BaseWidget
{
//     protected int | string | array $columnSpan = 'full';
    protected ?string $pollingInterval = '10s';
    protected function getStats(): array
    {
       $query = \App\Models\Property::query();
           $filters = $this->filters ?? [];

           if (!empty($filters['city'])) {
               $query->where('city', $filters['city']);
           }

           if (!empty($filters['from_date'])) {
               $query->whereDate('created_at', '>=', $filters['from_date']);
           }

           if (!empty($filters['to_date'])) {
               $query->whereDate('created_at', '<=', $filters['to_date']);
           }
        $totalProperties = Property::count();
        $lastMonthProperties = Property::whereMonth('created_at', now()->subMonth()->month)->count();

        $totalLeads = Inquiry::count();
        $newLeads = Inquiry::where('status', 'new')->count();
        $contacted = Inquiry::where('status', 'contacted')->count();
        $closed = Inquiry::where('status', 'closed')->count();
        return [

             Stat::make('Total Properties', $totalProperties)
                            ->description($this->getTrend($totalProperties, $lastMonthProperties))
                            ->descriptionIcon('heroicon-m-arrow-trending-up')
                            ->color('primary'),

                        Stat::make('Active Listings', Property::where('status', 'available')->count())
                            ->description('Live properties')
                            ->descriptionIcon('heroicon-m-home')
                            ->color('success'),

                        Stat::make('Total Users', User::count())
                            ->description('Platform users')
                            ->descriptionIcon('heroicon-m-users')
                            ->color('info'),


                        Stat::make('Total Blogs', Blog::count())
                            ->description('All Blogs')
                            ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                            ->color('warning'),

                            //  Properties
                        Stat::make('Total Properties', Property::count())
                            ->description('All listings')
                            ->color('primary'),

                        // Leads
                        Stat::make('Total Leads', Inquiry::count())
                                                    ->description('Customer inquiries')
                                                    ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                                                    ->color('warning'),

                        Stat::make('New Leads', $newLeads)
                            ->description('Fresh inquiries')
                            ->color('warning'),

                        Stat::make('Contacted', $contacted)
                            ->description('Followed up')
                            ->color('primary'),

                        Stat::make('Closed Deals', $closed)
                            ->description('Converted leads')
                            ->color('success'),

            \Filament\Widgets\StatsOverviewWidget\Stat::make('Filtered Properties', $query->count()),
        ];
    }

    private function getTrend($current, $previous)
    {
        if ($previous == 0) return 'No previous data';

        $change = (($current - $previous) / $previous) * 100;

        return ($change > 0 ? '↑ ' : '↓ ') . round($change, 1) . '% from last month';
    }
}
