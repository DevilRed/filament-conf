<?php

namespace App\Filament\Resources\Conferences\Schemas;

use App\Enums\Region;
use App\Filament\Resources\Speakers\SpeakerResource;
use App\Filament\Resources\Venues\Schemas\VenueForm;
use App\Models\Speaker;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                // this works as a parent select, so when the user selects a region, the venue select field is refreshed
                ->live() // enable livewire, any change to this select, make a request to the server and the whole component is going to be re-rendered, so the closure in venue field is going to run again

                ->enum(Region::class) // to validate only enum vals are allowed
                ->options(Region::class), // get options from enum

            Select::make('venue_id') // this is the child field, a conference has many venues
                ->searchable() // search box
                ->preload() // preload list values, so the search is faster, recommended for small lists

                ->createOptionForm(VenueForm::getForm()) // show + icon to add a venue, clicking on it will open the create form modal

                ->editOptionForm(VenueForm::getForm()) // pass the form to the edit action, once the value is selected, an edit icon will appear, clicking on it will open the edit form modal

                ->relationship(name: 'venue', titleAttribute: 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                    // make venue dependent on region field value using $get to get the value of the region field
                    return $query->where('region', $get('region'));
                }),
            CheckboxList::make('speakers')
                ->relationship('speakers', 'name')
                ->options(
                    Speaker::all()->pluck('name', 'id'),
                )
                ->required(),
            ]);
    }
}
