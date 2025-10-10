<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('permissions.sections.permission_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('permissions.fields.name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('guard_name')
                            ->label(__('permissions.fields.guard_name'))
                            ->default('web')
                            ->required()
                            ->maxLength(255),
                    ]),
                Section::make(__('permissions.sections.roles'))
                    ->schema([
                        CheckboxList::make('roles')
                            ->label(__('permissions.fields.roles'))
                            ->relationship('roles', 'name')
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable(),
                    ]),
            ]);
    }
}
