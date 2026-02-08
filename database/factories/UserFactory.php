<?php

namespace Database\Factories;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Users\Subjects;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        //日本語Faker
        $faker = \Faker\Factory::create('ja_JP');
        $sex = $faker->randomElement([1, 2]);

        return [
            'over_name' => $faker->lastName,
            'under_name' => $faker->firstName,
            'over_name_kana' => $faker->lastKanaName,
            'under_name_kana' => $faker->firstKanaName,
            'mail_address' => $faker->unique()->safeEmail,
            'sex' => $faker->numberBetween(1, 2), // 1:男性 2:女性（想定）
            'birth_day' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'role' => $faker->numberBetween(1, 3), // 例：1=一般 2=管理者 など
            'password' => Hash::make('password'), // 固定でOK
            'remember_token' => \Illuminate\Support\Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    //ランダムな初期ユーザーにランダムな選択科目を付与
    public function configure()
    {
        return $this->afterCreating(function ($user) {

            // subjects テーブルに存在する科目IDから、ランダムで1〜3個選ぶ
            $subjectIds = Subjects::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id')
                ->toArray();

            // 科目が0件なら何もしない（ここ重要）
            if (count($subjectIds) === 0) {
                return;
            }

            // pivot(subject_users) にレコードが作成される
            $user->subjects()->attach($subjectIds);
        });
    }
}
