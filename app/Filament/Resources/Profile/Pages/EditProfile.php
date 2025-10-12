<?php

namespace App\Filament\Resources\Profile\Pages;

use App\Filament\Resources\Profile\ProfileResource;
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
        return __('users.profile.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('users.profile.title');
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
                    ->title(__('users.profile.current_password_required'))
                    ->danger()
                    ->send();

                $this->halt();
            }

            if (!Hash::check($data['current_password'], $record->password)) {
                Notification::make()
                    ->title(__('users.profile.current_password_incorrect'))
                    ->danger()
                    ->send();

                $this->halt();
            }
        }

        // Delete old profile image if new one uploaded
        if (isset($data['profile_image']) && $data['profile_image'] !== $record->profile_image) {
            if ($record->profile_image) {
                Storage::disk('public')->delete($record->profile_image);
            }
        }

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
        return __('users.profile.update_success');
    }
}
