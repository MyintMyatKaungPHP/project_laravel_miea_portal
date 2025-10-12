<?php

return [
    'resource' => [
        'label' => 'Role',
        'plural_label' => 'Roles',
    ],

    'navigation' => [
        'group' => 'User Management',
    ],

    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'guard_name' => 'Guard Name',
        'permissions' => 'Permissions',
        'users_count' => 'Users Count',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'role_information' => 'Role Information',
        'permissions' => 'Permissions',
        'system_information' => 'System Information',
    ],
    'messages' => [
        'no_permissions' => 'No permissions assigned',
    ],
];
