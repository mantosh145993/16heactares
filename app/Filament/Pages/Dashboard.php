<?php
namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms;
use Filament\Forms\Form;

class Dashboard extends BaseDashboard
{
protected static ?string $title = 'Dashboard';
    public ?array $filters = [];

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\InquiryPipeline::class,
            \App\Filament\Widgets\PropertyChart::class,
            \App\Filament\Widgets\PropertyTypeChart::class,
            \App\Filament\Widgets\PropertyStatusChart::class,
        ];
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('city')
                    ->label('City')
                    ->options(\App\Models\Property::pluck('city', 'city'))
                    ->searchable(),
                Forms\Components\DatePicker::make('from_date')
                    ->label('From Date'),
                Forms\Components\DatePicker::make('to_date')
                    ->label('To Date'),
            ])
            ->statePath('filters');
    }
}
