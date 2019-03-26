<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 准备数据
        $userIds = User::all()->pluck('id')->toArray();
        $topicIds = Topic::all()->pluck('id')->toArray();
        $faker = app(Faker\Generator::class);
        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use ($userIds, $topicIds, $faker) {
            $reply->user_id = $faker->randomElement($userIds);
            $reply->topic_id = $faker->randomElement($topicIds);
        });

        Reply::insert($replys->toArray());
    }

}

