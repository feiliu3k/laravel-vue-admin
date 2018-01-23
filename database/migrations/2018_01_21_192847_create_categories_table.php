<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->string("name", 40)->comment('分类名称');
            $table->string("alias", 40)->comment('分类别名');
            $table->string("data", 255)->nullable()->comment('其它信息');
            $table->integer("pattern_id")->unsigned()->comment('模型编号');
            $table->integer("parent_id")->unsigned()->nullable()->comment('上级编号');
            $table->foreign("parent_id")
                ->references('id')->on('categories');
            $table->foreign("pattern_id")
                ->references('id')->on('patterns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
