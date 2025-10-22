<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use App\Models\ServiceCard;
use App\Models\Testimonial;
use App\Models\Partner;
use App\Models\Leadership;
use App\Models\SchoolAchievement;
use App\Models\ProgrammeImage;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class ManageSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $slug = 'settings';

    public function getTitle(): string | Htmlable
    {
        return 'Site Settings';
    }

    public function getHeading(): string | Htmlable
    {
        return 'Site Settings';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Manage settings for your frontend website';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(int | string $record = null): void
    {
        // Get or create the site settings record
        $this->record = SiteSetting::current();

        $this->fillForm();
    }

    protected function authorizeAccess(): void
    {
        // Allow access to users with appropriate permissions
        // You can customize this based on your authorization logic
    }

    protected function getRedirectUrl(): ?string
    {
        // Stay on the same page (and same tab) after saving
        return null;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Settings saved successfully';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle service cards data
        if (isset($data['service_cards']) && is_array($data['service_cards'])) {
            $this->saveServiceCards($data['service_cards']);
            unset($data['service_cards']); // Remove from main data array
        }

        // Handle testimonials data
        if (isset($data['testimonials']) && is_array($data['testimonials'])) {
            $this->saveTestimonials($data['testimonials']);
            unset($data['testimonials']); // Remove from main data array
        }

        // Handle partners data
        if (isset($data['partners']) && is_array($data['partners'])) {
            $this->savePartners($data['partners']);
            unset($data['partners']); // Remove from main data array
        }

        // Handle Leadership data
        if (isset($data['leadership'])) {
            $this->saveLeadership($data['leadership']);
            unset($data['leadership']); // Remove from main data array
        }

        // Handle School Achievement data
        if (isset($data['school_achievements'])) {
            $this->saveSchoolAchievements($data['school_achievements']);
            unset($data['school_achievements']); // Remove from main data array
        }

        // Handle Programme Images data
        if (isset($data['programme_images'])) {
            $this->saveProgrammeImages($data['programme_images']);
            unset($data['programme_images']); // Remove from main data array
        }

        // Debug: Log the data being saved
        \Log::info('SiteSetting save data:', $data);

        return $data;
    }

    protected function saveServiceCards(array $serviceCards): void
    {
        // Delete existing service cards
        ServiceCard::truncate();

        // Create new service cards
        foreach ($serviceCards as $serviceCardData) {
            if (!empty($serviceCardData['title']) && !empty($serviceCardData['details'])) {
                ServiceCard::create([
                    'title' => $serviceCardData['title'],
                    'details' => $serviceCardData['details'],
                    'image' => is_array($serviceCardData['image']) ? $serviceCardData['image'][0] : $serviceCardData['image'],
                    'overlay_color' => $serviceCardData['overlay_color'] ?? null,
                    'link' => $serviceCardData['link'] ?? null,
                    'active' => $serviceCardData['active'] ?? true,
                ]);
            }
        }
    }

    protected function saveTestimonials(array $testimonials): void
    {
        // Delete existing testimonials
        Testimonial::truncate();

        // Create new testimonials
        foreach ($testimonials as $testimonialData) {
            if (!empty($testimonialData['name']) && !empty($testimonialData['content'])) {
                Testimonial::create([
                    'name' => $testimonialData['name'],
                    'role' => $testimonialData['role'] ?? '',
                    'content' => $testimonialData['content'],
                    'image' => is_array($testimonialData['image']) ? $testimonialData['image'][0] : $testimonialData['image'],
                    'is_active' => $testimonialData['is_active'] ?? true,
                ]);
            }
        }
    }

    protected function savePartners(array $partners): void
    {
        // Delete existing partners
        Partner::truncate();

        // Create new partners
        foreach ($partners as $partnerData) {
            if (!empty($partnerData['name'])) {
                Partner::create([
                    'name' => $partnerData['name'],
                    'image' => is_array($partnerData['image']) ? $partnerData['image'][0] : $partnerData['image'],
                    'is_active' => $partnerData['is_active'] ?? true,
                ]);
            }
        }
    }

    protected function saveLeadership(array $leadership): void
    {
        // Delete existing leadership
        Leadership::truncate();

        // Create new leadership
        foreach ($leadership as $leadershipData) {
            if (!empty($leadershipData['name']) && !empty($leadershipData['role'])) {
                Leadership::create([
                    'site_setting_id' => $this->record->id,
                    'name' => $leadershipData['name'],
                    'role' => $leadershipData['role'],
                    'image' => is_array($leadershipData['image']) ? $leadershipData['image'][0] : $leadershipData['image'],
                    'color_code' => $leadershipData['color_code'] ?? '#3B82F6',
                    'is_active' => $leadershipData['is_active'] ?? true,
                ]);
            }
        }
    }

    protected function saveSchoolAchievements(array $schoolAchievements): void
    {
        // Delete existing school achievements
        SchoolAchievement::truncate();

        // Create new school achievements
        foreach ($schoolAchievements as $achievementData) {
            if (!empty($achievementData['ac_year']) && !empty($achievementData['achievement_list'])) {
                SchoolAchievement::create([
                    'site_setting_id' => $this->record->id,
                    'ac_year' => $achievementData['ac_year'],
                    'achievement_list' => $achievementData['achievement_list'],
                    'is_active' => $achievementData['is_active'] ?? true,
                ]);
            }
        }
    }

    protected function saveProgrammeImages(array $programmeImages): void
    {
        // Delete existing programme images
        ProgrammeImage::truncate();

        // Create new programme images
        foreach ($programmeImages as $programmeImageData) {
            if (!empty($programmeImageData['programme_name'])) {
                ProgrammeImage::create([
                    'site_setting_id' => $this->record->id,
                    'programme_name' => $programmeImageData['programme_name'],
                    'images' => $programmeImageData['images'],
                ]);
            }
        }
    }

    protected function fillForm(): void
    {
        $this->form->fill([
            // Load existing service cards
            'service_cards' => ServiceCard::where('active', true)->orderBy('id', 'asc')->get()->map(function ($serviceCard) {
                return [
                    'title' => $serviceCard->title,
                    'details' => $serviceCard->details,
                    'image' => $serviceCard->image,
                    'overlay_color' => $serviceCard->overlay_color,
                    'link' => $serviceCard->link,
                    'active' => $serviceCard->active,
                ];
            })->toArray(),

            // Load existing testimonials
            'testimonials' => Testimonial::all()->map(function ($testimonial) {
                return [
                    'name' => $testimonial->name,
                    'role' => $testimonial->role,
                    'content' => $testimonial->content,
                    'image' => $testimonial->image,
                    'is_active' => $testimonial->is_active,
                ];
            })->toArray(),

            // Load existing partners
            'partners' => Partner::all()->map(function ($partner) {
                return [
                    'name' => $partner->name,
                    'image' => $partner->image,
                    'is_active' => $partner->is_active,
                ];
            })->toArray(),

            // Load existing leadership
            'leadership' => Leadership::all()->map(function ($leadership) {
                return [
                    'name' => $leadership->name,
                    'role' => $leadership->role,
                    'image' => $leadership->image,
                    'color_code' => $leadership->color_code,
                    'is_active' => $leadership->is_active,
                ];
            })->toArray(),

            // Load existing school achievements
            'school_achievements' => SchoolAchievement::all()->map(function ($achievement) {
                return [
                    'ac_year' => $achievement->ac_year,
                    'achievement_list' => $achievement->achievement_list,
                    'is_active' => $achievement->is_active,
                ];
            })->toArray(),

            // Load existing programme images
            'programme_images' => ProgrammeImage::all()->map(function ($programmeImage) {
                return [
                    'programme_name' => $programmeImage->programme_name,
                    'images' => $programmeImage->images,
                ];
            })->toArray(),

            // Load other site settings
            ...$this->record->toArray(),
        ]);
    }
}
