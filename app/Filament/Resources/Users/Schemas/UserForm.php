<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('users.sections.user_information'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('users.fields.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('users.fields.email'))
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        DateTimePicker::make('email_verified_at')
                            ->label(__('users.fields.email_verified_at')),
                    ]),
                Section::make(__('users.sections.roles'))
                    ->schema([
                        Select::make('roles')
                            ->label(__('users.fields.roles'))
                            ->multiple()
                            ->relationship(
                                'roles',
                                'name',
                                fn($query) => auth()->user()?->hasRole('super_admin')
                                    ? $query
                                    : $query->where('name', '!=', 'super_admin')
                            )
                            ->preload()
                            ->searchable(),
                    ]),
                Section::make(__('users.sections.password'))
                    ->schema([
                        TextInput::make('password')
                            ->label(__('users.fields.password'))
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->rule(Password::default())
                            ->same('passwordConfirmation')
                            ->validationAttribute(__('users.fields.password')),
                        TextInput::make('passwordConfirmation')
                            ->label(__('users.fields.password_confirmation'))
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrated(false)
                            ->validationAttribute(__('users.fields.password_confirmation')),
                    ]),
            ]);
    }
}
