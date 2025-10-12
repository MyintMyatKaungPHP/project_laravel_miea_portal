<?php

return [
    'resource' => [
        'label' => 'Permission',
        'plural_label' => 'Permissions',
    ],

    'navigation' => [
        'group' => 'User Management',
    ],

    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'guard_name' => 'Guard Name',
        'roles' => 'Roles',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'permission_information' => 'Permission Information',
        'roles' => 'Roles',
        'system_information' => 'System Information',
    ],
    'messages' => [
        'no_roles' => 'No roles assigned',
    ],
];
