<?php

namespace App\Filament\Resources\Profile\Pages;

use App\Filament\Resources\Profile\ProfileResource;
use App\Models\Image;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected static ?string $slug = 'myprofile';

    public function getTitle(): string | Htmlable
    {
        return __('My Profile');
    }

    public function getHeading(): string | Htmlable
    {
        return __('My Profile');
    }


    protected function getHeaderActions(): array
    {
        return [];
    }


    public function mount(int | string $record = null): void
    {
        $this->record = auth()->user();

        $this->fillForm();
    }

    protected function authorizeAccess(): void
    {
        // Allow access - users can always edit their own profile
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load profile image from images relationship
        $profileImage = $this->record->images()
            ->where('imageable_type', \App\Models\User::class)
            ->where('imageable_id', $this->record->id)
            ->first();

        if ($profileImage) {
            $data['profile_image'] = $profileImage->path;
        }

        // Load roles
        $data['roles'] = ['name' => $this->record->roles->pluck('name')->toArray()];

        // Remove password fields
        unset($data['password']);
        unset($data['current_password']);
        unset($data['password_confirmation']);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Validate current password if changing password
        if (!empty($data['password'])) {
            if (empty($data['current_password'])) {
                Notification::make()
                    ->title(__('Current password is required to change password'))
                    ->danger()
                    ->send();

                $this->halt();
            }

            if (!Hash::check($data['current_password'], $record->password)) {
                Notification::make()
                    ->title(__('Current password is incorrect'))
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        // Get existing profile image
        $existingImage = $record->images()
            ->where('imageable_type', \App\Models\User::class)
            ->where('imageable_id', $record->id)
            ->first();

        // Handle profile image
        if (isset($data['profile_image'])) {
            if ($data['profile_image'] !== $existingImage?->path) {
                // Delete old image
                if ($existingImage) {
                    Storage::disk('public')->delete($existingImage->path);
                    $existingImage->delete();
                }

                // Save new image
                if (!empty($data['profile_image'])) {
                    Image::create([
                        'path' => $data['profile_image'],
                        'imageable_type' => \App\Models\User::class,
                        'imageable_id' => $record->id,
                        'user_id' => $record->id,
                        'post_id' => null,
                    ]);
                }
            }
        }

        // Remove profile_image from data
        unset($data['profile_image']);

        // Update password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Remove unnecessary fields
        unset($data['current_password']);
        unset($data['password_confirmation']);

        // Update the record
        $record->update($data);

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('Profile updated successfully');
    }
}
