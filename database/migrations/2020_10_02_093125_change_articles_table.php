<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('articles', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->default(1);
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('category_id')->unsigned()->default(1);
            $table->foreign('category_id')->references('id')->on('categories');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
