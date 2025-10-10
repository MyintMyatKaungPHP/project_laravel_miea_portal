<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name')
                    ->label(__('categories.fields.name'))
                    ->size('lg')
                    ->weight('bold'),

                TextEntry::make('slug')
                    ->label(__('categories.fields.slug'))
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                TextEntry::make('posts_count')
                    ->label(__('categories.fields.posts_count'))
                    ->state(fn($record) => $record->posts()->count())
                    ->badge()
                    ->color('success'),

                TextEntry::make('created_at')
                    ->label(__('categories.fields.created_at'))
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->label(__('categories.fields.updated_at'))
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
