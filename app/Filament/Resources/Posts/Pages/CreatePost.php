<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Image;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? auth()->id();

        // Store images temporarily
        $images = $data['images'] ?? [];
        unset($data['images']);

        // Store for afterCreate
        $this->cachedImages = $images;

        return $data;
    }

    protected function afterCreate(): void
    {
        // Save gallery images to images table
        if (!empty($this->cachedImages)) {
            foreach ($this->cachedImages as $imagePath) {
                Image::create([
                    'path' => $imagePath,
                    'imageable_type' => \App\Models\Post::class,
                    'imageable_id' => $this->record->id,
                    'user_id' => auth()->id(),
                    'post_id' => $this->record->id,
                ]);
            }
        }

        // Extract and save content images to images table
        $this->saveContentImages($this->record);
    }

    protected function saveContentImages(\App\Models\Post $post): void
    {
        // Extract image URLs from markdown content
        preg_match_all('/!\[.*?\]\((.*?)\)/', $post->content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Extract path from URL (e.g., "/storage/posts/content-images/abc.jpg" -> "posts/content-images/abc.jpg")
                if (str_contains($imageUrl, 'posts/content-images/')) {
                    $path = str_replace('/storage/', '', $imageUrl);

                    // Check if not already in database
                    $exists = Image::where('path', $path)
                        ->where('imageable_type', \App\Models\Post::class)
                        ->where('imageable_id', $post->id)
                        ->exists();

                    if (!$exists) {
                        Image::create([
                            'path' => $path,
                            'imageable_type' => \App\Models\Post::class,
                            'imageable_id' => $post->id,
                            'user_id' => auth()->id(),
                            'post_id' => $post->id,
                        ]);
                    }
                }
            }
        }
    }

    protected array $cachedImages = [];
}
