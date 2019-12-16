<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReactionsTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_reactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('reactionable_type');
            $table->string('emoji');
            $table->string('emoji_name');
            $table->unsignedBigInteger('reactionable_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('chatter_reactions');
    }
}
