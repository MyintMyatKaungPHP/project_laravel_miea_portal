<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Image;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing images from images table
        $existingImages = $this->record->images()->pluck('path')->toArray();
        $data['images'] = $existingImages;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Store new images temporarily
        $newImages = $data['images'] ?? [];
        unset($data['images']);

        // Store for afterSave
        $this->cachedImages = $newImages;

        return $data;
    }

    protected function afterSave(): void
    {
        // Get existing gallery images (not content images)
        $existingImages = $this->record->images()
            ->where('path', 'like', 'posts/images/%')
            ->pluck('path')
            ->toArray();

        // Find deleted images
        $deletedImages = array_diff($existingImages, $this->cachedImages);

        // Delete removed images
        if (!empty($deletedImages)) {
            foreach ($deletedImages as $imagePath) {
                // Delete from storage
                Storage::disk('public')->delete($imagePath);

                // Delete from database
                Image::where('path', $imagePath)
                    ->where('imageable_type', \App\Models\Post::class)
                    ->where('imageable_id', $this->record->id)
                    ->delete();
            }
        }

        // Add new images
        $newlyAdded = array_diff($this->cachedImages, $existingImages);
        if (!empty($newlyAdded)) {
            foreach ($newlyAdded as $imagePath) {
                Image::create([
                    'path' => $imagePath,
                    'imageable_type' => \App\Models\Post::class,
                    'imageable_id' => $this->record->id,
                    'user_id' => auth()->id(),
                    'post_id' => $this->record->id,
                ]);
            }
        }

        // Extract and save content images
        $this->saveContentImages($this->record);
    }

    protected function saveContentImages(\App\Models\Post $post): void
    {
        // Extract image URLs from markdown content
        preg_match_all('/!\[.*?\]\((.*?)\)/', $post->content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Extract path from URL
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
