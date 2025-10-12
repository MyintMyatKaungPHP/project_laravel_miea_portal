<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                ImageEntry::make('profile_image')
                    ->label(__('users.fields.profile_image'))
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn(User $record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF')
                    ->columnSpan(1),

                Section::make(__('users.sections.user_information'))
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('users.fields.id')),
                        TextEntry::make('name')
                            ->label(__('users.fields.name')),
                        TextEntry::make('email')
                            ->label(__('users.fields.email'))
                            ->copyable(),
                        TextEntry::make('email_verified_at')
                            ->label(__('users.fields.email_verified_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Section::make(__('users.sections.roles'))
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label(__('users.fields.roles'))
                            ->badge()
                            ->placeholder(__('users.messages.no_roles')),
                    ])
                    ->columnSpanFull(),
                Section::make(__('users.sections.system_information'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('users.fields.created_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label(__('users.fields.updated_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed(),
            ]);
    }
}
