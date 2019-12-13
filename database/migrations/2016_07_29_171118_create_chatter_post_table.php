<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterPostTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('discussion_id');
            $table->unsignedBigInteger('user_id');
            
            $table->text('body');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('chatter_post');
    }
}
