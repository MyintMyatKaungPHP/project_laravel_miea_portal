<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set as SchemaSet;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('posts.sections.post_information'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('posts.fields.title'))
                            ->required()
                            ->autofocus()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, SchemaSet $set) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label(__('posts.fields.slug'))
                            ->required()
                            ->readOnly()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('category_id')
                            ->label(__('posts.fields.category'))
                            ->relationship('category', 'name')
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),

                        MarkdownEditor::make('content')
                            ->label(__('posts.fields.content'))
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),

                // Sidebar (single column) containing Media, Meta, Authorship stacked
                Section::make()
                    ->schema([
                        Section::make(__('posts.sections.media'))
                            ->collapsible()
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label(__('posts.fields.thumbnail'))
                                    ->disk('public')
                                    ->directory('thumbnails'),
                            ]),

                        Section::make(__('posts.sections.meta'))
                            ->collapsible()
                            ->schema([
                                TagsInput::make('tags')
                                    ->label(__('posts.fields.tags')),

                                Toggle::make('published')
                                    ->label(__('posts.fields.published'))
                                    ->default(false),
                            ]),

                        Section::make(__('posts.sections.authorship'))
                            ->collapsible()
                            ->schema([
                                TextInput::make('user_id')
                                    ->label(__('posts.fields.author'))
                                    ->hidden()
                                    ->default(auth()->id())
                                    ->readOnly()
                                    ->required(),

                                TextInput::make('author_name')
                                    ->label(__('posts.fields.author_name'))
                                    ->default(auth()->user()->name ?? null)
                                    ->disabled(),
                            ]),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
