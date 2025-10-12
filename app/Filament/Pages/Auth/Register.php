<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                FileUpload::make('profile_image')
                    ->label(__('users.fields.profile_image'))
                    ->disk('public')
                    ->directory('profile_images')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->maxSize(2048)
                    ->helperText(__('users.profile.upload_profile_picture'))
                    ->columnSpanFull(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function handleRegistration(array $data): Model
    {
        // Extract profile_image before creating user
        $profileImage = $data['profile_image'] ?? null;
        unset($data['profile_image']);

        // Create user (password already hashed by getPasswordFormComponent)
        $user = User::create($data);

        // Update profile_image if uploaded
        if ($profileImage) {
            $user->update(['profile_image' => $profileImage]);
        }

        return $user;
    }
}
