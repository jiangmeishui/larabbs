<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 使用$faker实例操作数据
        // 生成模型实例并添加相应faker无法添加的数据
        // 插入数据
        // 对第一条数据进行操作,将数据信息改成我们想要的信息
        $faker = app(Faker\Generator::class);
        $avatars = [
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];
        $users = factory(User::class)->times(10)->make()->each(function ($user) use ($avatars, $faker) {
           $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见,并将集合转为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $res = User::find(1);
        $res->name = 'jiang';
        $res->email = '237132868@qq.com';
        $res->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $res->save();
    }
}
