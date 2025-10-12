<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Image;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing profile image from images table
        $profileImage = $this->record->images()
            ->where('imageable_type', \App\Models\User::class)
            ->where('imageable_id', $this->record->id)
            ->first();

        if ($profileImage) {
            $data['profile_image'] = $profileImage->path;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Prevent non-super-admins from assigning super_admin role
        if (!auth()->user()?->hasRole('super_admin') && isset($data['roles'])) {
            $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'super_admin')->first();

            if ($superAdminRole && in_array($superAdminRole->id, $data['roles'])) {
                Notification::make()
                    ->title('Unauthorized Action')
                    ->body('You cannot assign the Super Admin role.')
                    ->danger()
                    ->send();

                // Remove super_admin from roles array
                $data['roles'] = array_diff($data['roles'], [$superAdminRole->id]);
            }
        }

        // Handle email_verified_at field
        if (array_key_exists('email_verified_at', $data)) {
            // Keep the value as is (can be null or timestamp)
            // This ensures the field is properly updated in database
        }

        // Store new profile image temporarily
        if (isset($data['profile_image'])) {
            $this->cachedProfileImage = $data['profile_image'];
            unset($data['profile_image']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Get existing profile image
        $existingImage = $this->record->images()
            ->where('imageable_type', \App\Models\User::class)
            ->where('imageable_id', $this->record->id)
            ->first();

        // If new image is different from existing
        if ($this->cachedProfileImage !== $existingImage?->path) {
            // Delete old image
            if ($existingImage) {
                Storage::disk('public')->delete($existingImage->path);
                $existingImage->delete();
            }

            // Save new image
            if (!empty($this->cachedProfileImage)) {
                Image::create([
                    'path' => $this->cachedProfileImage,
                    'imageable_type' => \App\Models\User::class,
                    'imageable_id' => $this->record->id,
                    'user_id' => $this->record->id,
                    'post_id' => null,
                ]);
            }
        }
    }

    protected ?string $cachedProfileImage = null;
}
