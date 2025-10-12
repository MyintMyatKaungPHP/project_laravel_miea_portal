<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
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
        // Set is_verified toggle state based on email_verified_at
        $data['is_verified'] = $this->record->email_verified_at !== null;

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

        // Delete old profile image if new one uploaded
        if (isset($data['profile_image']) && $data['profile_image'] !== $this->record->profile_image) {
            if ($this->record->profile_image) {
                Storage::disk('public')->delete($this->record->profile_image);
            }
        }

        return $data;
    }
}
