<?php

return [
    'resource' => [
        'label' => 'Post',
        'plural_label' => 'Posts',
    ],

    'navigation' => [
        'group' => 'Blog',
    ],

    'fields' => [
        'thumbnail' => 'Thumbnail',
        'images' => 'Gallery Images',
        'title' => 'Title',
        'color' => 'Color',
        'slug' => 'Slug',
        'content' => 'Content',
        'tags' => 'Tags',
        'published' => 'Published',
        'author' => 'Author',
        'author_name' => 'Author name',
        'category' => 'Category',
        'comments_count' => 'Comments',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'deleted_at' => 'Deleted At',
    ],

    'status' => [
        'draft' => 'Draft',
        'published' => 'Published',
    ],

    'sections' => [
        'post_information' => 'Post Information',
        'media' => 'Media',
        'meta' => 'Meta',
        'authorship' => 'Authorship',
        'content' => 'Content',
        'publishing' => 'Publishing',
        'category' => 'Category',
        'image' => 'Image',
    ],

    'helpers' => [
        'slug' => 'URL-friendly version of the title',
        'tags' => 'Add tags and press Enter',
        'thumbnail' => 'Image size must not exceed 2MB',
    ],

    'filters' => [
        'published' => 'Published',
        'category' => 'Category',
        'author' => 'Author',
        'trashed' => 'Trashed',
    ],

    'actions' => [
        'create' => 'Create Post',
        'edit' => 'Edit Post',
        'delete' => 'Delete Post',
        'restore' => 'Restore Post',
        'force_delete' => 'Permanently Delete',
    ],
];
