<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Actions\Action;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
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
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Toggle::make('is_verified')
                            ->label('Email Verified')
                            ->inline(false)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('email_verified_at', now());
                                } else {
                                    $set('email_verified_at', null);
                                }
                            })
                            ->default(fn($record) => $record?->email_verified_at !== null)
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        DateTimePicker::make('email_verified_at')
                            ->label(__('users.fields.email_verified_at'))
                            ->nullable()
                            ->seconds(false)
                            ->displayFormat('d/m/Y H:i')
                            ->helperText('Toggle above to set/unset verification, or manually select date/time')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                Section::make(__('users.sections.profile_image'))
                    ->schema([
                        FileUpload::make('profile_image')
                            ->label(__('users.fields.profile_image'))
                            ->disk('private')
                            ->directory('users/profiles')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->maxSize(2048)
                            ->helperText('Upload a profile picture'),
                    ])
                    ->columnSpan(1),
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
                    ])
                    ->columnSpanFull(),
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
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
