<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('CategoryID');
            $table->string('CategoryName');
            $table->unsignedBigInteger('ParentCategoryID')->nullable();
            $table->foreign('ParentCategoryID')->references('CategoryID')->on('categories');
            $table->string('ImageURL')->nullable();
            $table->text('Description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
