<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('permissions.sections.permission_information'))
                    ->schema([
                        TextEntry::make('id')
                            ->label(__('permissions.fields.id')),
                        TextEntry::make('name')
                            ->label(__('permissions.fields.name')),
                        TextEntry::make('guard_name')
                            ->label(__('permissions.fields.guard_name'))
                            ->badge(),
                    ])
                    ->columns(2),
                Section::make(__('permissions.sections.roles'))
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label(__('permissions.fields.roles'))
                            ->badge()
                            ->placeholder(__('permissions.messages.no_roles')),
                    ]),
                Section::make(__('permissions.sections.system_information'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('permissions.fields.created_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label(__('permissions.fields.updated_at'))
                            ->dateTime('Y-m-d H:i:s')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
