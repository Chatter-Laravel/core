<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterDiscussionTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_discussions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('color', 20)->nullable()->default('#232629');
            $table->unsignedBigInteger('category_id')->default('1');
            $table->unsignedBigInteger('user_id');
            $table->boolean('sticky')->default(false);
            $table->unsignedBigInteger('views')->default('0');
            $table->boolean('answered')->default(0);
            $table->timestamp('last_reply_at')->useCurrent();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('chatter_categories')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('chatter_discussions');
    }
}
