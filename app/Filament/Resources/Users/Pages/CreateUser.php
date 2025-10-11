<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
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

        return $data;
    }
}
