<?php

use App\Models\News;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all()->pluck('id')->toArray();

        factory(News::class, 50)
            ->create()
            ->each(function (News $news) use ($tags) {
                $randomTadsId = Arr::random($tags, rand(1, 3));
                $news->tags()->sync($randomTadsId);
            });
    }
}
