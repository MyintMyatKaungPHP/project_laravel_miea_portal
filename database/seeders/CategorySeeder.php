<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'color' => '#10b981',
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Health & Safety',
                'slug' => 'health-safety',
                'color' => '#eab308',
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'color' => '#10b981',
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'color' => '#ef4444',
            ],
            [
                'name' => 'Knowledge',
                'slug' => 'knowledge',
                'color' => '#8b5cf6',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
