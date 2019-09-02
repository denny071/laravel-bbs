<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);


        // 生成数据集合
        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) {
            // 从头像数据中随机抽取一个并赋值
            $user->avatar = $this->getAvatar();
        });

        // 让隐藏字段课件，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户数据
        $user = User::find(1);
        $user->name = 'xiaoming';
        $user->email = 'xiaoming@qq.com';
        $user->save();

        $user->assignRole('Founder');

        // $user = User::find(2);
        // $user->assignRole('Maintainer');
    }

    /**
     * 获得随机头像地址
     *
     * @return string
     */
    public function getAvatar()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.uomg.com/api/rand.avatar?format=json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output,true);

        if ($data['code'] == 1) {
            return $data['imgurl'];
        }else {
            return "";
        }
    }


}
