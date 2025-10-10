<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Sidebar image (1 column)
                ImageEntry::make('thumbnail')
                    ->label(__('posts.fields.thumbnail'))
                    ->disk('public')
                    ->visibility('public')
                    ->placeholder('No thumbnail image')
                    ->columnSpan(1),

                // Main info (2 columns)
                TextEntry::make('title')
                    ->label(__('posts.fields.title'))
                    ->size('lg')
                    ->weight('bold')
                    ->columnSpan(2),

                TextEntry::make('slug')
                    ->label(__('posts.fields.slug'))
                    ->copyable()
                    ->badge()
                    ->color('gray')
                    ->columnSpan(2),

                TextEntry::make('category.name')
                    ->label(__('posts.fields.category'))
                    ->placeholder('-')
                    ->badge()
                    ->color('info')
                    ->columnSpan(1),

                ColorEntry::make('color')
                    ->label(__('posts.fields.color'))
                    ->placeholder('-')
                    ->columnSpan(1),

                IconEntry::make('published')
                    ->label(__('posts.fields.published'))
                    ->boolean()
                    ->columnSpan(1),

                TextEntry::make('user.name')
                    ->label(__('posts.fields.author'))
                    ->columnSpan(1),

                TextEntry::make('tags')
                    ->label(__('posts.fields.tags'))
                    ->badge()
                    ->separator(',')
                    ->placeholder('-')
                    ->columnSpan(2),

                TextEntry::make('created_at')
                    ->label(__('posts.fields.created_at'))
                    ->dateTime()
                    ->placeholder('-')
                    ->columnSpan(1),

                TextEntry::make('updated_at')
                    ->label(__('posts.fields.updated_at'))
                    ->dateTime()
                    ->placeholder('-')
                    ->columnSpan(1),

                TextEntry::make('deleted_at')
                    ->label(__('posts.fields.deleted_at'))
                    ->dateTime()
                    ->visible(fn(Post $record): bool => $record->trashed())
                    ->placeholder('-')
                    ->columnSpan(1),

                TextEntry::make('content')
                    ->label(__('posts.fields.content'))
                    ->html()
                    ->columnSpanFull(),
            ]);
    }
}
