<?php

// namespace database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => '国外新闻',
            'alias' => 'news',
            'data' => null,
            'pattern_id' => 1,
            'parent_id'=>null,
        ]);
    }
}
