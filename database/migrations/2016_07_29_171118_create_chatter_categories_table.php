<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatterCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('chatter_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(1);
            $table->string('name');
            $table->string('subtitle');
            $table->string('slug')->unique();
            $table->string('color', 20);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('chatter_categories');
    }
}
