<?php

namespace App\Filament\Resources\Speakers\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SpeakerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('twitter_handle')
                    ->required(),
            CheckboxList::make('qualifications')
                ->columnSpanFull()
                ->searchable()
                ->options([
                    'business-leader' => 'Business Leader',
                    'charisma' => 'Charismatic Speaker',
                    'first-time' => 'First Time Speaker',
                    'hometown-hero' => 'Hometown Hero',
                    'humanitarian' => 'Works in Humanitarian Field',
                    'laracast-contributor' => 'Laracast Contributor',
                    'twitter-influencer' => 'Large Twitter Following',
                    'youtube-influencer' => 'Large YouTube Following',
                    'open-source' => 'Open Source Creator / Maintainer',
                    'unique-perspective' => 'Unique Perspective',
                ])
                ->descriptions([ // just as example
                    'business-leader' => 'Here is a nice long description',
                    'charisma' => 'This is even more information about why you should pick this one',
                ])
                ->columns(3)
            ]);
    }
}
