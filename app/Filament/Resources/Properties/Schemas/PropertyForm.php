<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('type')
                    ->options(['sale' => 'Sale', 'rent' => 'Rent'])
                    ->required(),
                Select::make('property_type')
                    ->options(['apartment' => 'Apartment', 'villa' => 'Villa', 'plot' => 'Plot', 'office' => 'Office'])
                    ->required(),
                TextInput::make('bedrooms')
                    ->numeric()
                    ->default(null),
                TextInput::make('bathrooms')
                    ->numeric()
                    ->default(null),
                TextInput::make('area')
                    ->numeric()
                    ->default(null),
                TextInput::make('address')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('state')
                    ->default(null),
                TextInput::make('country')
                    ->required()
                    ->default('India'),
                TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->options(['available' => 'Available', 'sold' => 'Sold', 'rented' => 'Rented'])
                    ->default('available')
                    ->required(),
                TextInput::make('owner_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('agent_id')
                    ->numeric()
                    ->default(null),
                Section::make('Property Images')->schema([
                        Repeater::make('images')
                            ->relationship()
                            ->schema([
                                FileUpload::make('image_url')
                                    ->image()
                                    ->disk('public')
                                    ->directory('properties')
                                    ->required(),
                                Toggle::make('is_featured')
                                    ->label('Featured'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Image')
                            ->reorderable()
                            ->columnSpanFull(),

                    ]),

            ]);
    }
}
