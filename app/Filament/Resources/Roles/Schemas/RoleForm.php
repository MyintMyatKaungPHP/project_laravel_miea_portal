<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        // Group permissions by resource
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

        // Create CheckboxList for each resource group
        $permissionComponents = [];
        foreach ($groupedPermissions as $resource => $perms) {
            $permissionIds = collect($perms)->pluck('id')->toArray();
            $permissionComponents[] = Section::make($resource . ' Permissions')
                ->schema([
                    CheckboxList::make('permissions')
                        ->label(false)
                        ->relationship('permissions', 'name')
                        ->options(collect($perms)->pluck('name', 'id')->toArray())
                        ->columns(2)
                        ->bulkToggleable(),
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
                    ]),
                Section::make(__('roles.sections.permissions'))
                    ->schema($permissionComponents)
                    ->columns(2),
            ]);
    }
}
