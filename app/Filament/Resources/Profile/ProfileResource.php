<?php

namespace App\Filament\Resources\Profile;

use App\Filament\Resources\Profile\Pages\EditProfile;
use App\Filament\Resources\Profile\Schemas\ProfileForm;
use App\Filament\Resources\Profile\Schemas\ProfileInfolist;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?int $navigationSort = 100;

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $shouldSkipAuthorization = true;

    public static function getNavigationLabel(): string
    {
        return __('Profile Settings');
    }

    public static function getModelLabel(): string
    {
        return __('Profile');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Profile');
    }

    public static function form(Schema $schema): Schema
    {
        return ProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProfileInfolist::configure($schema);
    }

    public static function canAccess(): bool
    {
        return auth()->check();
    }

    public static function canViewAny(): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return $record->id === auth()->id();
    }

    public static function canView(Model $record): bool
    {
        return $record->id === auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getIndexUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null, bool $shouldGuessMissingParameters = false): string
    {
        return static::getUrl('edit', $parameters, $isAbsolute, $panel, $tenant);
    }

    public static function getPages(): array
    {
        return [
            'edit' => EditProfile::route('/myprofile'),
        ];
    }
}
