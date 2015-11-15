<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoolresultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poolresults', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('query_qid');
            $table->integer('story_sid');
            $table->integer('count')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('poolresults');
    }
}
