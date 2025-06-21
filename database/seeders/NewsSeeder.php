<?php

namespace Database\Seeders;

use App\News;
use App\Category;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = Category::all();
        
        // Get users by role
        $wartawan = User::role('wartawan')->first();
        $editor = User::role('editor')->first();
        $admin = User::role('admin')->first();
        
        // Sample news articles data
        $newsArticles = [
            [
                'title' => 'Kebijakan Baru untuk Ekonomi Indonesia',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in velit metus. Donec auctor, nisl eget ultricies tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl sit amet nisl.',
                'category' => 'Ekonomi',
                'status' => 'published',
                'is_published' => true,
            ],
            [
                'title' => 'Tim Nasional Sepak Bola Menang Besar',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in velit metus. Donec auctor, nisl eget ultricies tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl sit amet nisl.',
                'category' => 'Olahraga',
                'status' => 'published',
                'is_published' => true,
            ],
            [
                'title' => 'Inovasi Teknologi Terbaru dari Startup Lokal',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in velit metus. Donec auctor, nisl eget ultricies tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl sit amet nisl.',
                'category' => 'Teknologi',
                'status' => 'published',
                'is_published' => true,
            ],
            [
                'title' => 'Pandemi Covid-19: Update Terbaru',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in velit metus. Donec auctor, nisl eget ultricies tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl sit amet nisl.',
                'category' => 'Kesehatan',
                'status' => 'draft',
                'is_published' => false,
            ],
            [
                'title' => 'Artis Terkenal Menikah di Bali',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in velit metus. Donec auctor, nisl eget ultricies tincidunt, nunc nisl aliquam nisl, eget aliquam nunc nisl sit amet nisl.',
                'category' => 'Hiburan',
                'status' => 'draft',
                'is_published' => false,
            ],
        ];
        
        foreach ($newsArticles as $article) {
            $categoryId = $categories->where('name', $article['category'])->first()->id;
            $published = $article['is_published'];
            $status = $article['status'];
            
            $news = News::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'image' => null, // You could generate random images if needed
                'category_id' => $categoryId,
                'user_id' => $wartawan->id, // All articles are created by a reporter (wartawan)
                'is_published' => $published,
                'published_at' => $published ? Carbon::now() : null,
                'views' => $published ? rand(10, 1000) : 0,
                'likes' => $published ? rand(5, 100) : 0,
                'dislikes' => $published ? rand(0, 20) : 0,
                'status' => $status,
                // Only editors can approve articles, so only published ones get approved
                'approved_by' => $published ? $editor->id : null, 
            ]);
        }
        
        // Create a few more news items with different variations
        // 1. Draft article by admin (waiting for editor approval)
        News::create([
            'title' => 'Draft Article by Admin',
            'slug' => 'draft-article-by-admin',
            'content' => 'This is a draft article created by an admin, waiting for editor approval.',
            'category_id' => $categories->random()->id,
            'user_id' => $admin->id,
            'is_published' => false,
            'status' => 'draft',
            'approved_by' => null,
        ]);
        
        // 2. Draft article by reporter (wartawan)
        News::create([
            'title' => 'Breaking News: Still Being Written',
            'slug' => 'breaking-news-draft',
            'content' => 'This is a breaking news article that is still being written by a reporter.',
            'category_id' => $categories->random()->id,
            'user_id' => $wartawan->id,
            'is_published' => false,
            'status' => 'draft',
            'approved_by' => null,
        ]);
        
        // 3. Archived article
        News::create([
            'title' => 'Old News That Was Archived',
            'slug' => 'old-news-archived',
            'content' => 'This is an old news article that has been archived.',
            'category_id' => $categories->random()->id,
            'user_id' => $wartawan->id,
            'is_published' => false,
            'published_at' => Carbon::now()->subMonths(6),
            'status' => 'archived',
            'approved_by' => $editor->id,
            'views' => 2500,
            'likes' => 320,
            'dislikes' => 15,
        ]);
    }
}