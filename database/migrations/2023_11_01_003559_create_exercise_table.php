<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('app_image')->nullable();
            $table->integer('image')->nullable();
            $table->integer('audio')->nullable();
            $table->integer('video')->nullable();
            $table->unsignedInteger('type_id')->nullable();
            $table->integer('topic_id')->nullable();
            $table->integer('part_id');
            $table->unsignedInteger('level')->nullable();
            $table->unsignedInteger('platform_id')->nullable();
            $table->tinyInteger('is_active')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('exercises');
    }
};
