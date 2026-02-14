<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //英語・国語・数学を追加
        DB::table('sub_categories')->insert([
            [
                'main_category_id' => '1',
                'sub_category' => '英語',
            ],
            [
                'main_category_id' => '1',
                'sub_category' => '国語',
            ],
            [
                'main_category_id' => '1',
                'sub_category' => '数学',
            ]
        ]);
    }
}
