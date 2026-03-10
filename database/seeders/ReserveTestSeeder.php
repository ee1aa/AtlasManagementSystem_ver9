<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Calendars\ReserveSettings;
use Illuminate\Support\Facades\DB;

class ReserveTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d1 = '2026-03-01';
        $d2 = '2026-03-28';

        // 🔹 過去日の部作成
        $part1 = ReserveSettings::updateOrCreate([
            'setting_reserve' => $d1,
            'setting_part' => 1,
            'limit_users' => 20,
        ]);

        $part2 = ReserveSettings::updateOrCreate([
            'setting_reserve' => $d1,
            'setting_part' => 2,
            'limit_users' => 20,
        ]);

        // 🔹 未来日の部
        $futurePart = ReserveSettings::updateOrCreate([
            'setting_reserve' => $d2,
            'setting_part' => 1,
            'limit_users' => 20,
        ]);

        // 🔹 pivot テーブル登録
        DB::table('reserve_setting_users')->insert([
            [
                'user_id' => 6,
                'reserve_setting_id' => $part1->id,
                'created_at' => now(),
            ],
            [
                'user_id' => 7,
                'reserve_setting_id' => $part2->id,
                'created_at' => now(),
            ],
            [
                'user_id' => 6,
                'reserve_setting_id' => $futurePart->id,
                'created_at' => now(),
            ],
        ]);
    }
}
