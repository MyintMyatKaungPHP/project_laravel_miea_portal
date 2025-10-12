<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ToggleColumn::make('is_verified')
                    ->label('Verified')
                    ->getStateUsing(fn($record) => $record->email_verified_at !== null)
                    ->updateStateUsing(function ($record, $state) {
                        $record->update([
                            'email_verified_at' => $state ? now() : null,
                        ]);
                    })
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('email_verified_at', $direction);
                    }),
                ImageColumn::make('profile_image')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'),
                TextColumn::make('name')
                    ->label(__('users.fields.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('users.fields.email'))
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('roles.name')
                    ->label(__('users.fields.roles'))
                    ->badge()
                    ->searchable(),
                TextColumn::make('id')
                    ->label(__('users.fields.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email_verified_at')
                    ->label(__('users.fields.email_verified_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('users.fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('users.fields.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}
