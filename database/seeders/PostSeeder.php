<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->info('Users နှင့် Categories မရှိသေးပါ။ ဦးစွာ Users နှင့် Categories တွေ ဖန်တီးပါ။');
            return;
        }

        $posts = [
            [
                'thumbnail' => null,
                'title' => 'Laravel Filament ဖြင့် Admin Panel တည်ဆောက်ခြင်း',
                'color' => '#3b82f6',
                'slug' => 'laravel-filament-admin-panel',
                'content' => '<h2>Laravel Filament အကြောင်း</h2><p>Laravel Filament သည် Laravel application များအတွက် admin panel တည်ဆောက်ရန် အင်မတန်ကောင်းမွန်သော package တစ်ခုဖြစ်ပါသည်။</p><p>Filament ၏ အားသာချက်များမှာ:</p><ul><li>လွယ်ကူစွာ အသုံးပြုနိုင်မှု</li><li>Modern UI design</li><li>အပြည့်အစုံသော CRUD operations</li><li>Customizable components</li></ul>',
                'tags' => ['laravel', 'filament', 'php', 'admin'],
                'published' => true,
            ],
            [
                'thumbnail' => null,
                'title' => 'Web Development လေ့လာသင့်သော အကြောင်းအရာများ',
                'color' => '#10b981',
                'slug' => 'web-development-topics',
                'content' => '<h2>Web Development အခြေခံများ</h2><p>Web Development စလေ့လာသူများအတွက် HTML, CSS, JavaScript တို့သည် အခြေခံအကျဆုံး သင်ယူရမည့် နည်းပညာများဖြစ်ပါသည်။</p><h3>Frontend Development</h3><ul><li>HTML5</li><li>CSS3</li><li>JavaScript</li><li>React / Vue / Angular</li></ul><h3>Backend Development</h3><ul><li>PHP / Laravel</li><li>Node.js</li><li>Python / Django</li><li>Database Management</li></ul>',
                'tags' => ['web', 'development', 'programming'],
                'published' => true,
            ],
            [
                'thumbnail' => null,
                'title' => 'စီးပွားရေး လုပ်ငန်း စတင်ရန် လမ်းညွှန်',
                'color' => '#f59e0b',
                'slug' => 'business-startup-guide',
                'content' => '<h2>လုပ်ငန်း စတင်ခြင်း</h2><p>ကိုယ့်လုပ်ငန်း စတင်ရန် အရေးကြီးသော အချက်များမှာ:</p><ol><li>စျေးကွက် လေ့လာခြင်း</li><li>စီးပွားရေး အစီအစဉ် ရေးဆွဲခြင်း</li><li>ရန်ပုံငွေ စီမံခြင်း</li><li>ဥပဒေဆိုင်ရာ လိုက်နာမှုများ</li></ol>',
                'tags' => ['business', 'startup', 'entrepreneur'],
                'published' => true,
            ],
            [
                'thumbnail' => null,
                'title' => 'ပညာရေး စနစ်တိုးတက်ရေး',
                'color' => '#8b5cf6',
                'slug' => 'education-system-improvement',
                'content' => '<h2>ပညာရေး စနစ်</h2><p>ခေတ်မီ ပညာရေး စနစ်တွင် နည်းပညာကို ထည့်သွင်း အသုံးပြုမှု အလွန်အရေးကြီးပါသည်။</p>',
                'tags' => ['education', 'technology'],
                'published' => false,
            ],
            [
                'thumbnail' => null,
                'title' => 'ကျန်းမာရေး စောင့်ရှောက်မှု အကြောင်း',
                'color' => '#ef4444',
                'slug' => 'healthcare-tips',
                'content' => '<h2>ကျန်းမာရေး အကြံပြုချက်များ</h2><ul><li>ပုံမှန် လေ့ကျင့်ခန်း လုပ်ဆောင်ပါ</li><li>အာဟာရ ပြည့်ဝသော အစားအစာ စားပါ</li><li>လုံလောက်သော အိပ်စက် အနားယူပါ</li><li>စိတ်ဖိစီးမှု လျှော့ချပါ</li></ul>',
                'tags' => ['health', 'wellness', 'lifestyle'],
                'published' => true,
            ],
            [
                'thumbnail' => null,
                'title' => 'ကိုယ်ရေးကာကွယ်မှု အကြောင်း',
                'color' => '#10b981',
                'slug' => 'self-care-tips',
                'content' => '<h2>ကိုယ်ရေးကာကွယ်မှု အကြံပြုချက်များ</h2><ul><li>ပုံမှန် လေ့ကျင့်ခန်း လုပ်ဆောင်ပါ</li><li>အာဟာရ ပြည့်ဝသော အစားအစာ စားပါ</li><li>လုံလောက်သော အိပ်စက် အနားယူပါ</li><li>စိတ်ဖိစီးမှု လျှော့ချပါ</li></ul>',
                'tags' => ['self-care', 'wellness', 'lifestyle'],
                'published' => true,
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'thumbnail' => $postData['thumbnail'],
                'title' => $postData['title'],
                'color' => $postData['color'],
                'slug' => $postData['slug'],
                'content' => $postData['content'],
                'tags' => $postData['tags'],
                'published' => $postData['published'],
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ]);
        }

        $this->command->info('Posts ဖန်တီးပြီးပါပြီ: ' . count($posts) . ' posts');
    }
}
