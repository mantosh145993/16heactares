<?php
namespace App\Filament\Resources\Properties\Schemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('property_type')
                    ->badge(),
                TextEntry::make('bedrooms')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('bathrooms')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('area')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('address'),
                TextEntry::make('city'),
                TextEntry::make('state')
                    ->placeholder('-'),
                TextEntry::make('country'),
                TextEntry::make('latitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('longitude')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('owner_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('agent_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                   Section::make('Property Images')
                    ->schema([
                        RepeatableEntry::make('images')
                            ->schema([
                                ImageEntry::make('image_url')
                                    ->disk('public')
                                ->height(120),
                        ])
                        ->columnSpanFull(),
                ]),
            ]);
    }
}
