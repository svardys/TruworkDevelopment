<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('gallery_id')->constrained()->onDelete('cascade');;
            $table->string('original_name');
            $table->string('path');
            $table->string('extension');
            $table->integer('size');
            $table->boolean('thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['gallery_id']);
        });
        Schema::dropIfExists('images');
    }
}
