<?php

namespace App\Filament\Resources\Conferences\Schemas;

use App\Enums\Region;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class ConferenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Conference Label')
                    ->hint('Conference Hint')
                    ->hintIcon('heroicon-o-rectangle-stack')
                    ->required()
                    ->maxLength(60),
                RichEditor::make('description')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('end_date')
                    ->required(),
                // new field
                Checkbox::make('is_published')
                    ->default(true),
                Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Select::make('region')
                    // dependent select with livewire
                    ->live()// make a request to the server to refresh section
                    ->enum(Region::class)// to validate only enum vals are allowed
                    ->options(Region::class),
                Select::make('venue_id')
                ->relationship('venue', 'name', function (Builder $query, Get $get) {
                    return $query->where('region',  $get('region'));
                })
                    ->default(null),
            ]);
    }
}
