<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->morphs('imageable');
            $table->string('big'); // 1200x* image
            $table->string('medium'); // 600x* image
            $table->string('thumbnail');   // 250x* image
            $table->string('icon'); // 64x64 image
            $table->smallInteger('order')->default(1);
            $table->smallInteger('type')->default(1); // main use is in Work orders
            $table->boolean('processing')->default(1);
            // protect for not having the same order more than once
            $table->unique(['imageable_type', 'imageable_id', 'order']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
