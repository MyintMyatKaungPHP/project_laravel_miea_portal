<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('users.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('users.resource.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('users.resource.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('users.resource.plural_label');
    }

    public static function getNavigationBadge(): ?string
    {
        $verified = static::getModel()::whereNotNull('email_verified_at')->count();
        $notVerified = static::getModel()::whereNull('email_verified_at')->count();

        return "✓ {$verified} | ✗ {$notVerified}";
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary'; // Filament default primary color
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $verified = static::getModel()::whereNotNull('email_verified_at')->count();
        $notVerified = static::getModel()::whereNull('email_verified_at')->count();

        return "Verified: {$verified} | Not Verified: {$notVerified}";
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        // Hide users with super_admin role from non-super-admins
        if (!auth()->user()?->hasRole('super_admin')) {
            $query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super_admin');
            });
        }

        return $query;
    }
}
