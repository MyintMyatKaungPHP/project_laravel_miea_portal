<?php

namespace App\Filament\Resources\Profile\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Profile Information'))
                    ->schema([
                        ImageEntry::make('profile_image_url')
                            ->label(__('users.fields.profile_image'))
                            ->circular()
                            ->columnSpanFull(),

                        TextEntry::make('name')
                            ->label(__('users.fields.name')),

                        TextEntry::make('email')
                            ->label(__('users.fields.email'))
                            ->copyable()
                            ->icon('heroicon-m-envelope'),

                        TextEntry::make('email_verified_at')
                            ->label(__('users.fields.email_verified_at'))
                            ->dateTime()
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn($state) => $state ? 'Verified' : 'Not Verified'),

                        TextEntry::make('roles.name')
                            ->label(__('users.fields.roles'))
                            ->badge()
                            ->color('primary')
                            ->separator(',')
                            ->default(__('users.messages.no_roles')),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('users.sections.system_information'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('users.fields.created_at'))
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label(__('users.fields.updated_at'))
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed(),
            ]);
    }
}
