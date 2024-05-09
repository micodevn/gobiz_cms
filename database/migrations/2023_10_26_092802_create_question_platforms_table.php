<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('description');
            $table->integer('parent_id')->nullable();
            $table->integer('image_id')->nullable();
            $table->string('media_types')->nullable();
            $table->text('attribute_options')->nullable();
            $table->string('doc_link');
            $table->tinyInteger('use_new_platform')->nullable()->default(0);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('question_platforms');
    }
};
