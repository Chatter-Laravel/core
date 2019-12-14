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
            $table->string('color', 20)->nullable()->default('#232629');
            $table->unsignedBigInteger('category_id')->default('1');
            $table->unsignedBigInteger('user_id');
            $table->boolean('sticky')->default(false);
            $table->unsignedBigInteger('views')->default('0');
            $table->boolean('answered')->default(0);
            $table->timestamp('last_reply_at')->useCurrent();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('chatter_discussion');
    }
}
