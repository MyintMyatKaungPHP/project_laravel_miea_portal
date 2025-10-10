<?php

return [
    'resource' => [
        'label' => 'User',
        'plural_label' => 'Users',
    ],
    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email Address',
        'email_verified_at' => 'Email Verified At',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'roles' => 'Roles',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'user_information' => 'User Information',
        'password' => 'Password',
        'roles' => 'Roles',
        'system_information' => 'System Information',
    ],
    'messages' => [
        'no_roles' => 'No roles assigned',
    ],
];
