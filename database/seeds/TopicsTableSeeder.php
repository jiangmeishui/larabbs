<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $userIds = User::all()->pluck('id')->toArray();
        $categoryIds = Category::all()->pluck('id')->toArray();
        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use ($faker, $userIds, $categoryIds) {
            $topic->user_id = $faker->randomElement($userIds);
            $topic->category_id = $faker->randomElement($categoryIds);
        });

        Topic::insert($topics->toArray());
    }

}

