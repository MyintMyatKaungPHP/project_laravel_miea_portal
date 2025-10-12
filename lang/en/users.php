<?php

return [
    'resource' => [
        'label' => 'User',
        'plural_label' => 'Users',
    ],

    'navigation' => [
        'group' => 'User Management',
    ],

    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email Address',
        'email_verified_at' => 'Email Verified At',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'roles' => 'Roles',
        'profile_image' => 'Profile Picture',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
    'sections' => [
        'user_information' => 'User Information',
        'profile_image' => 'Profile Picture',
        'password' => 'Password',
        'roles' => 'Roles',
        'system_information' => 'System Information',
    ],
    'messages' => [
        'no_roles' => 'No roles assigned',
    ],

    'profile' => [
        'title' => 'My Profile',
        'edit_title' => 'Edit Profile',
        'account_status' => 'Account Status',
        'verified' => 'Verified',
        'not_verified' => 'Not Verified',
        'current_password' => 'Current Password',
        'new_password' => 'New Password',
        'confirm_password' => 'Confirm New Password',
        'change_password' => 'Change Password',
        'leave_blank' => 'Leave blank to keep current password',
        'update_success' => 'Profile updated successfully',
        'update_failed' => 'Failed to update profile',
        'current_password_incorrect' => 'Current password is incorrect',
        'current_password_required' => 'Current password is required to change password',
        'password_changed' => 'Password changed successfully',
        'upload_profile_picture' => 'Upload a profile picture',
        'helper_text' => [
            'current_password' => 'Enter your current password to change it',
            'new_password' => 'Minimum 8 characters',
            'confirm_password' => 'Re-enter your new password',
        ],
    ],
];
