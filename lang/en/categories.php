<?php

return [
    'resource' => [
        'label' => 'Category',
        'plural_label' => 'Categories',
    ],

    'navigation' => [
        'group' => 'Blog',
    ],

    'fields' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'color' => 'Color',
        'posts_count' => 'Posts Count',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At',
    ],

    'sections' => [
        'basic_info' => 'Basic Information',
    ],

    'helpers' => [
        'slug' => 'URL-friendly version of the name',
    ],

    'filters' => [
        'trashed' => 'Trashed',
    ],

    'actions' => [
        'create' => 'Create Category',
        'edit' => 'Edit Category',
        'delete' => 'Delete Category',
    ],
];
