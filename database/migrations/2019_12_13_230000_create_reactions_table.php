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
        });
    }

    public function down()
    {
        Schema::drop('chatter_reactions');
    }
}
