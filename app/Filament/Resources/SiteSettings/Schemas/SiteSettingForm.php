<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function schema(): array
    {
        return [
            Tabs::make('Settings')
                ->contained(true)
                ->vertical()
                ->persistTabInQueryString()
                ->columnSpanFull()
                ->schema([
                    // Basic Information Tab
                    Tab::make('basic')
                        ->label('Basic Information')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            // Maintenance Mode Section
                            Section::make('Maintenance Mode')
                                ->description('Control website maintenance mode')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Toggle::make('maintenance_mode')
                                        ->label('Enable Maintenance Mode')
                                        ->helperText('Enable this to show maintenance page to visitors'),

                                    Textarea::make('maintenance_message')
                                        ->label('Maintenance Message')
                                        ->rows(3)
                                        ->placeholder('Website is currently under maintenance. Please check back later.')
                                        ->columnSpanFull(),
                                ])->columns(2),

                            // Basic Site Information Section
                            Section::make('Basic Site Information')
                                ->description('Basic website settings')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('site_name')
                                        ->label('Site Name')
                                        ->maxLength(255)
                                        ->minLength(3)
                                        ->helperText('Minimum 3 characters required'),

                                    Textarea::make('site_description')
                                        ->label('Site Description')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->minLength(10)
                                        ->helperText('Minimum 10 characters required'),

                                    FileUpload::make('site_logo_light')
                                        ->label('Site Logo (Light Mode)')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/logos')
                                        ->maxSize(2048)
                                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                                        ->helperText('Max 2MB, PNG/JPEG/WebP formats only'),

                                    FileUpload::make('site_logo_dark')
                                        ->label('Site Logo (Dark Mode)')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/logos')
                                        ->maxSize(2048)
                                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                                        ->helperText('Max 2MB, PNG/JPEG/WebP formats only'),

                                    FileUpload::make('site_favicon')
                                        ->label('Favicon')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/logos')
                                        ->maxSize(512)
                                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/ico'])
                                        ->helperText('Max 512KB, PNG/ICO format recommended'),
                                ])->columns(2),

                            // Contact Information Section
                            Section::make('Contact Information')
                                ->description('Contact details for the website')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('contact_email')
                                        ->label('Primary Email')
                                        ->email()
                                        ->maxLength(255)
                                        ->helperText('Primary contact email address'),

                                    TextInput::make('contact_email_2')
                                        ->label('Secondary Email')
                                        ->email()
                                        ->maxLength(255)
                                        ->helperText('Optional secondary email address'),

                                    TextInput::make('contact_phone')
                                        ->label('Primary Phone')
                                        ->tel()
                                        ->maxLength(20)
                                        ->minLength(10)
                                        ->helperText('Primary contact phone number'),

                                    TextInput::make('contact_phone_2')
                                        ->label('Secondary Phone')
                                        ->tel()
                                        ->maxLength(20)
                                        ->minLength(10)
                                        ->helperText('Optional secondary phone number'),

                                    Textarea::make('contact_address')
                                        ->label('Contact Address')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->minLength(10)
                                        ->helperText('Complete physical address')
                                        ->columnSpanFull(),
                                ])->columns(2),

                            // Social Media Links Section
                            Section::make('Social Media Links')
                                ->description('Social media platform links')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('facebook_url')
                                        ->label('Facebook URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full Facebook page URL'),

                                    TextInput::make('instagram_url')
                                        ->label('Instagram URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full Instagram profile URL'),

                                    TextInput::make('linkedin_url')
                                        ->label('LinkedIn URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full LinkedIn company/profile URL'),

                                    TextInput::make('youtube_url')
                                        ->label('YouTube URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full YouTube channel URL'),

                                    TextInput::make('telegram_url')
                                        ->label('Telegram URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full Telegram channel/group URL'),

                                    TextInput::make('tiktok_url')
                                        ->label('TikTok URL')
                                        ->url()
                                        ->maxLength(255)
                                        ->helperText('Full TikTok profile URL'),
                                ])->columns(2),

                            // Footer Section
                            Section::make('Footer')
                                ->description('Footer content and settings')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Textarea::make('footer_text')
                                        ->label('Copyright Text')
                                        ->rows(2)
                                        ->placeholder('© 2024 MIEA Portal. All rights reserved.')
                                        ->columnSpanFull(),

                                    Textarea::make('footer_description')
                                        ->label('Footer Description')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->columnSpanFull(),

                                    FileUpload::make('footer_logo')
                                        ->label('Footer Logo')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/footer')
                                        ->maxSize(2048)
                                        ->helperText('Max 2MB'),
                                ])->columns(1),

                            // SEO Section
                            Section::make('SEO Settings')
                                ->description('Search engine optimization settings')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rows(3)
                                        ->maxLength(160)
                                        ->helperText('Recommended: 150-160 characters')
                                        ->columnSpanFull(),

                                    Textarea::make('meta_keywords')
                                        ->label('Meta Keywords')
                                        ->rows(2)
                                        ->maxLength(255)
                                        ->placeholder('education, MIEA, school, courses')
                                        ->columnSpanFull(),

                                    TextInput::make('google_analytics_id')
                                        ->label('Google Analytics ID')
                                        ->placeholder('G-XXXXXXXXXX')
                                        ->maxLength(50),
                                ])->columns(1),
                        ]),

                    // Home Page Tab
                    Tab::make('homepage')
                        ->label('Home Page')
                        ->icon('heroicon-o-home')
                        ->schema([
                            // Page Under Maintenance Section (labels only; keeps DB fields)
                            Section::make('Page Under Maintenance')
                                ->description('Show under maintenance message on homepage')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Toggle::make('page_under_maintenance')
                                        ->label('Enable Page Under Maintenance')
                                        ->helperText('Show under maintenance message on homepage'),

                                    Textarea::make('under_maintenance_message')
                                        ->label('Under Maintenance Message')
                                        ->rows(3)
                                        ->placeholder('This page is currently under maintenance. Please check back soon.')
                                        ->columnSpanFull(),
                                ])->columns(2),

                            // Hero Section
                            Section::make('Hero Section')
                                ->description('Main banner section of homepage')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('school_name')
                                        ->label('School Name')
                                        ->maxLength(255)
                                        ->placeholder('MIEA International School'),

                                    TagsInput::make('typewriter_texts')
                                        ->label('Typewriter Texts')
                                        ->placeholder('Add typewriter text')
                                        ->helperText('Texts that will be displayed in typewriter effect'),

                                    Textarea::make('intro_text')
                                        ->label('Intro Text')
                                        ->rows(3)
                                        ->maxLength(500)
                                        ->placeholder('Welcome to MIEA...')
                                        ->columnSpanFull(),

                                    FileUpload::make('hero_images')
                                        ->label('Hero Image')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/hero')
                                        ->maxSize(3072)
                                        ->helperText('Max 3MB')
                                        ->columnSpanFull(),

                                    TextInput::make('hero_button_text')
                                        ->label('Button Text')
                                        ->maxLength(50)
                                        ->placeholder('Learn More'),

                                    TextInput::make('hero_button_link')
                                        ->label('Button Link')
                                        ->url()
                                        ->maxLength(255)
                                        ->placeholder('/about'),

                                    Toggle::make('hero_button_show')
                                        ->label('Show Button')
                                        ->helperText('Toggle to show/hide the hero button')
                                        ->default(true),
                                ])->columns(2),

                            // Service Cards Section
                            Section::make('Service Cards Section')
                                ->description('Service cards displayed on homepage')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('service_cards')
                                        ->label('Service Cards')
                                        ->schema([
                                            TextInput::make('title')
                                                ->label('Title')
                                                ->maxLength(255)
                                                ->placeholder('A Level'),

                                            Textarea::make('details')
                                                ->label('Details')
                                                ->rows(2)
                                                ->maxLength(500)
                                                ->placeholder('Year 12 - Year 13 (iAS & iAL)'),

                                            FileUpload::make('image')
                                                ->label('Background Image')
                                                ->image()
                                                ->imageEditor()
                                                ->disk('public')
                                                ->directory('site/service_cards')
                                                ->maxSize(2048)
                                                ->helperText('Max 2MB'),

                                            ColorPicker::make('overlay_color')
                                                ->label('Overlay Color')
                                                ->default('#ef4444')
                                                ->helperText('Color for hover overlay effect')
                                                ->rgb()
                                                ->hex(),

                                            TextInput::make('link')
                                                ->label('Link')
                                                ->placeholder('/programmes')
                                                ->helperText('Link to navigate when card is clicked'),

                                            TextInput::make('tag_name')
                                                ->label('Tag ID')
                                                ->maxLength(255)
                                                ->placeholder('1')
                                                ->helperText('Tag name for categorization')
                                                ->prefix('#'),

                                            Toggle::make('active')
                                                ->label('Active')
                                                ->default(true),
                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['title'] ?? null),
                                ])->columns(1),

                            // About Section
                            Section::make('About Section')
                                ->description('About content on homepage')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('about_title')
                                        ->label('About Title')
                                        ->maxLength(255)
                                        ->placeholder('About MIEA'),

                                    RichEditor::make('about_content')
                                        ->label('About Content')
                                        ->toolbarButtons([
                                            'bold',
                                            'italic',
                                            'underline',
                                            'bulletList',
                                            'orderedList',
                                            'link',
                                        ])
                                        ->columnSpanFull(),

                                    FileUpload::make('about_image')
                                        ->label('About Image')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/about')
                                        ->maxSize(3072)
                                        ->helperText('Max 3MB'),

                                    Textarea::make('mission')
                                        ->label('Mission Statement')
                                        ->rows(4)
                                        ->maxLength(1000)
                                        ->placeholder('Our mission is to...')
                                        ->columnSpanFull(),

                                    Textarea::make('vision')
                                        ->label('Vision Statement')
                                        ->rows(4)
                                        ->maxLength(1000)
                                        ->placeholder('Our vision is to...')
                                        ->columnSpanFull(),
                                ])->columns(2),

                            // Achievement Section
                            Section::make('Achievement Section')
                                ->description('Statistics and achievements')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('graduated_students')
                                        ->label('Graduated Students')
                                        ->numeric()
                                        ->placeholder('0'),

                                    TextInput::make('qualified_teachers')
                                        ->label('Qualified Teachers')
                                        ->numeric()
                                        ->placeholder('0'),

                                    TextInput::make('student_teacher_ratio')
                                        ->label('Student-Teacher Ratio')
                                        ->placeholder('15:1')
                                        ->maxLength(20),

                                    TextInput::make('courses_offered')
                                        ->label('Courses Offered')
                                        ->numeric()
                                        ->placeholder('0'),
                                ])->columns(2),

                            // Testimonials Section
                            Section::make('Testimonials Section')
                                ->description('Customer testimonials and reviews')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('testimonials')
                                        ->label('Testimonials')
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('Name')
                                                ->maxLength(255),

                                            TextInput::make('role')
                                                ->label('Role/Title')
                                                ->maxLength(255),

                                            Textarea::make('content')
                                                ->label('Testimonial Content')
                                                ->rows(3)
                                                ->maxLength(1000),

                                            FileUpload::make('image')
                                                ->label('Profile Image')
                                                ->image()
                                                ->imageEditor()
                                                ->disk('public')
                                                ->directory('site/testimonials')
                                                ->maxSize(2048)
                                                ->helperText('Max 2MB'),


                                            Toggle::make('is_active')
                                                ->label('Active')
                                                ->default(true),
                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                                ])->columns(1),

                            // Intro Video Section
                            Section::make('Intro Video Section')
                                ->description('Introduction video on homepage')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    TextInput::make('intro_video_title')
                                        ->label('Video Title')
                                        ->maxLength(255)
                                        ->placeholder('Watch Our Story'),

                                    TextInput::make('intro_video_url')
                                        ->label('Video URL')
                                        ->url()
                                        ->maxLength(500)
                                        ->placeholder('https://youtube.com/watch?v=...')
                                        ->helperText('YouTube, Vimeo or direct video URL'),
                                ])->columns(2),

                            // Partner Section
                            Section::make('Partner Section')
                                ->description('Partner organizations and sponsors')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('partners')
                                        ->label('Partners')
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('Partner Name')
                                                ->maxLength(255),

                                            FileUpload::make('image')
                                                ->label('Partner Logo')
                                                ->image()
                                                ->imageEditor()
                                                ->disk('public')
                                                ->directory('site/partners')
                                                ->maxSize(2048)
                                                ->helperText('Max 2MB'),


                                            Toggle::make('is_active')
                                                ->label('Active')
                                                ->default(true),
                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                                ])->columns(1),
                        ]),

                    // Organizational Structure Page Tab
                    Tab::make('organizational_structure_page')
                        ->label('Organizational Structure Page')
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            // Leadership Section
                            Section::make('Leadership Cards')
                                ->description('Manage leadership team cards')
                                ->icon('heroicon-o-users')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('leadership')
                                        ->label('Leadership Cards')
                                        ->relationship('leadership')
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('Name')
                                                ->maxLength(255)
                                                ->placeholder('Dr. John Smith'),

                                            TextInput::make('role')
                                                ->label('Role/Position')
                                                ->maxLength(255)
                                                ->placeholder('Principal'),

                                            FileUpload::make('image')
                                                ->label('Profile Image')
                                                ->image()
                                                ->imageEditor()
                                                ->disk('public')
                                                ->directory('site/leadership')
                                                ->maxSize(2048)
                                                ->helperText('Max 2MB'),

                                            TextInput::make('color_code')
                                                ->label('Color Code')
                                                ->placeholder('#3B82F6')
                                                ->helperText('Hex color code for card styling'),


                                            Toggle::make('is_active')
                                                ->label('Active')
                                                ->default(true),
                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                                ])->columns(1),

                            // Organisational Structure Section
                            Section::make('Organisational Structure Images')
                                ->description('Upload organisational structure images for light and dark modes')
                                ->icon('heroicon-o-building-office-2')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    FileUpload::make('org_structure_image_light')
                                        ->label('Organisational Structure (Light Mode)')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/org-structure')
                                        ->maxSize(5120)
                                        ->helperText('Max 5MB - Image for light theme')
                                        ->columnSpan(1),

                                    FileUpload::make('org_structure_image_dark')
                                        ->label('Organisational Structure (Dark Mode)')
                                        ->image()
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('site/org-structure')
                                        ->maxSize(5120)
                                        ->helperText('Max 5MB - Image for dark theme')
                                        ->columnSpan(1),
                                ])->columns(2),
                        ]),

                    // School Achievement Tab
                    Tab::make('school_achievement')
                        ->label('School Achievement')
                        ->icon('heroicon-o-trophy')
                        ->schema([
                            // Yearly Achievement List Section
                            Section::make('Yearly Achievement List')
                                ->description('Manage yearly achievements by academic year')
                                ->icon('heroicon-o-calendar-days')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('school_achievements')
                                        ->label('Achievement Cards')
                                        ->relationship('schoolAchievements')
                                        ->schema([
                                            TextInput::make('ac_year')
                                                ->label('Academic Year')
                                                ->maxLength(255)
                                                ->placeholder('2024-2025'),

                                            TagsInput::make('achievement_list')
                                                ->label('Achievement List')
                                                ->placeholder('Add achievement')
                                                ->helperText('Enter each achievement as a separate item'),


                                            Toggle::make('is_active')
                                                ->label('Active')
                                                ->default(true),
                                        ])
                                        ->columns(2)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['ac_year'] ?? null),
                                ])->columns(1),
                        ]),

                    // Programmes Tab
                    Tab::make('programmes')
                        ->label('Programmes')
                        ->icon('heroicon-o-academic-cap')
                        ->schema([
                            // Programme Images Section
                            Section::make('Programme Images')
                                ->description('Upload multiple images for each programme')
                                ->icon('heroicon-o-photo')
                                ->collapsible()
                                ->collapsed()
                                ->schema([
                                    Repeater::make('programme_images')
                                        ->label('Programme Images')
                                        ->relationship('programmeImages')
                                        ->schema([
                                            Select::make('programme_name')
                                                ->label('Programme Name')
                                                ->options([
                                                    'A Level Programme' => 'A Level Programme',
                                                    'Upper Secondary Programme' => 'Upper Secondary Programme',
                                                    'Lower Secondary Programme' => 'Lower Secondary Programme',
                                                ])
                                                ->searchable()
                                                ->unique(),

                                            FileUpload::make('images')
                                                ->label('Programme Images')
                                                ->image()
                                                ->imageEditor()
                                                ->multiple()
                                                ->disk('public')
                                                ->directory('site/programmes')
                                                ->maxSize(3072)
                                                ->helperText('Multiple images for this programme - Max 3MB each')
                                                ->columnSpanFull(),
                                        ])
                                        ->columns(1)
                                        ->collapsible()
                                        ->itemLabel(fn(array $state): ?string => $state['programme_name'] ?? null),
                                ])->columns(1),
                        ]),

                ]),
        ];
    }
}
