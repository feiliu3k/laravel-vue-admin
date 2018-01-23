<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patterns', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->string( "name", 40 )->comment( "模型名称" );
            $table->string("alias", 40)->comment('模型别名');
            $table->string( "category_template", 40 )->comment( "分类模板" );
            $table->string( "list_template", 40 )->comment( "列表模板" );
            $table->string( "show_template", 40 )->comment( "显示模板" );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patterns');
    }
}
