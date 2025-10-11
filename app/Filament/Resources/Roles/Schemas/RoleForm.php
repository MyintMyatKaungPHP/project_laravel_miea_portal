<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        // Group permissions by resource (following Shield's approach)
        $permissions = \Spatie\Permission\Models\Permission::all();
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            if (strpos($permission->name, ':') !== false) {
                $parts = explode(':', $permission->name);
                $resource = end($parts);
            } else {
                $resource = 'Other';
            }
            $groupedPermissions[$resource][] = $permission;
        }

        ksort($groupedPermissions);

        // Create sections for each resource group (Shield-style)
        $permissionSections = [];
        foreach ($groupedPermissions as $resource => $perms) {
            $permissionSections[] = Section::make($resource)
                ->schema([
                    CheckboxList::make('permissions')
                        ->label(false)
                        ->options(function () use ($perms) {
                            $options = [];
                            foreach ($perms as $perm) {
                                if (strpos($perm->name, ':') !== false) {
                                    $action = explode(':', $perm->name)[0];
                                    // Convert camelCase to Title Case with spaces
                                    $label = preg_replace('/([a-z])([A-Z])/', '$1 $2', $action);
                                } else {
                                    $label = $perm->name;
                                }
                                $options[$perm->id] = $label;
                            }
                            return $options;
                        })
                        ->columns(2)
                        ->bulkToggleable()
                        ->live(),
                ])
                ->compact()
                ->collapsible();
        }

        return $schema
            ->components([
                Section::make(__('roles.sections.role_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('roles.fields.name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('guard_name')
                            ->label(__('roles.fields.guard_name'))
                            ->default('web')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make(__('roles.sections.permissions'))
                    ->schema($permissionSections)
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
