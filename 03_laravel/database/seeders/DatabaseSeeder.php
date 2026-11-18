<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $news = Category::create(['name' => 'News']);
        $tutorials = Category::create(['name' => 'Tutorials']);

        $laravel = Tag::create(['name' => 'Laravel']);
        $php = Tag::create(['name' => 'PHP']);
        Tag::create(['name' => 'Docker']);

        $post = $tutorials->posts()->create([
            'title' => 'Getting started with Eloquent',
            'body' => 'Models, migrations and relations in a nutshell.',
            'is_published' => true,
            'published_at' => now(),
        ]);
        $post->tags()->attach([$laravel->id, $php->id]);
        $post->comments()->create(['author' => 'Anna', 'body' => 'Great post!']);

        $draft = $news->posts()->create([
            'title' => 'Upcoming release (draft)',
            'body' => 'Not published yet.',
        ]);
        $draft->tags()->attach($laravel->id);

        $news->comments()->create(['author' => 'Ivan', 'body' => 'Waiting for more news.']);
    }
}
