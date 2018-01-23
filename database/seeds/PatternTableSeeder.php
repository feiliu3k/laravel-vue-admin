<?php

// namespace database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatternTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patterns')->insert([
            'id'=>1,
            'name' => '文章',
            'alias'=>'content',
            'category_template' => 'category_content',
            'list_template' => 'list_content',
            'show_template' => 'show_content',
        ]);
        DB::table('patterns')->insert([
            'id'=>2,
            'name' => '图片',
            'alias'=>'picture',
            'category_template' => 'category_picture',
            'list_template' => 'list_picture',
            'show_template' => 'show_picture',
        ]);

    }
}
