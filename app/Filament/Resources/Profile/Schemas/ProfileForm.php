<?php

namespace App\Filament\Resources\Profile\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('users.sections.user_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('users.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('email')
                            ->label(__('users.fields.email'))
                            ->email()
                            ->required()
                            ->disabled()
                            ->dehydrated(false)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Placeholder::make('account_status')
                            ->label(__('users.profile.account_status'))
                            ->content(fn($record) => $record?->email_verified_at
                                ? new \Illuminate\Support\HtmlString('<span class="fi-badge fi-color-success inline-flex items-center justify-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" style="background-color: rgb(220, 252, 231); color: rgb(22, 101, 52); --c-50: rgb(240, 253, 244); --c-400: rgb(74, 222, 128); --c-600: rgb(22, 163, 74);">
                                    <svg class="fi-color-custom h-3 w-3 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg>
                                    <span>' . __('users.profile.verified') . '</span>
                                </span>')
                                : new \Illuminate\Support\HtmlString('<span class="fi-badge fi-color-warning inline-flex items-center justify-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" style="background-color: rgb(254, 243, 199); color: rgb(146, 64, 14); --c-50: rgb(254, 252, 232); --c-400: rgb(251, 191, 36); --c-600: rgb(202, 138, 4);">
                                    <svg class="fi-color-custom h-3 w-3 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                                    <span>' . __('users.profile.not_verified') . '</span>
                                </span>'))
                            ->columnSpanFull(),

                        Placeholder::make('user_roles')
                            ->label(__('users.fields.roles'))
                            ->content(function ($record) {
                                if (!$record || !$record->roles || $record->roles->isEmpty()) {
                                    return new \Illuminate\Support\HtmlString('<span class="text-gray-500 text-sm">' . __('users.messages.no_roles') . '</span>');
                                }

                                $badges = $record->roles->map(function ($role) {
                                    return '<span class="fi-badge fi-color-primary inline-flex items-center justify-center gap-x-1 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset" style="background-color: rgb(254, 243, 199); color: rgb(180, 83, 9); --c-50: rgb(255, 251, 235); --c-400: rgb(251, 191, 36); --c-600: rgb(217, 119, 6);">
                                        <span>' . e($role->name) . '</span>
                                    </span>';
                                })->join(' ');

                                return new \Illuminate\Support\HtmlString('<div class="flex flex-wrap gap-1">' . $badges . '</div>');
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                Section::make(__('users.sections.profile_image'))
                    ->schema([
                        FileUpload::make('profile_image')
                            ->label(__('users.fields.profile_image'))
                            ->disk('public')
                            ->directory('users/profiles')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->maxSize(2048)
                            ->helperText(__('users.profile.upload_profile_picture')),
                    ])
                    ->columnSpan(1),

                Section::make(__('users.sections.password'))
                    ->description(__('users.profile.leave_blank'))
                    ->collapsed(false)
                    ->schema([
                        TextInput::make('current_password')
                            ->label(__('users.profile.current_password'))
                            ->password()
                            ->revealable()
                            ->nullable()
                            ->requiredWith('password')
                            ->helperText(__('users.profile.helper_text.current_password')),

                        TextInput::make('password')
                            ->label(__('users.profile.new_password'))
                            ->password()
                            ->revealable()
                            ->nullable()
                            ->confirmed()
                            ->minLength(8)
                            ->dehydrated(fn($state) => filled($state))
                            ->helperText(__('users.profile.helper_text.new_password')),

                        TextInput::make('password_confirmation')
                            ->label(__('users.profile.confirm_password'))
                            ->password()
                            ->revealable()
                            ->nullable()
                            ->dehydrated(false)
                            ->helperText(__('users.profile.helper_text.confirm_password')),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
