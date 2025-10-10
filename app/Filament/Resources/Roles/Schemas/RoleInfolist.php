<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('roles.sections.role_information'))
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('roles.fields.id')),
                        TextEntry::make('name')
                            ->label(__('roles.fields.name')),
                        TextEntry::make('guard_name')
                            ->label(__('roles.fields.guard_name'))
                            ->badge(),
                        TextEntry::make('users_count')
                            ->label(__('roles.fields.users_count'))
                            ->state(fn($record) => $record->users()->count()),
                    ])
                    ->columns(2),
                Section::make(__('roles.sections.permissions'))
                    ->schema([
                        TextEntry::make('permissions.name')
                            ->label(__('roles.fields.permissions'))
                            ->badge()
                            ->placeholder(__('roles.messages.no_permissions')),
                    ]),
                Section::make(__('roles.sections.system_information'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('roles.fields.created_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label(__('roles.fields.updated_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
