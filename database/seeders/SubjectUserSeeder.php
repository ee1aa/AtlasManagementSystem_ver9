<?php

namespace Database\Seeders;

use App\Models\Users\Subjects;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\User as AuthUser;

class SubjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $subjectIds = Subjects::pluck('id')->toArray();
        if (empty($subjectIds)) return;

        User::where('mail_address', 'like', '%@example.%')
            ->get()
            ->each(function ($user) use ($subjectIds) {

                // すでに選択済みならスキップ
                if ($user->subjects()->exists()) return;

                $pickIds = collect($subjectIds)
                    ->shuffle()
                    ->take(rand(1, 3))
                    ->toArray();

                $user->subjects()->attach($pickIds);
            });
    }
}
