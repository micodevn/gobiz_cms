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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('response_interaction_type')->default(\App\Models\Question::ITR_TYPE_NONE);
            $table->text('question_content')->nullable();
            $table->text('answers')->nullable();
            $table->integer('platform_id');
            $table->integer('topic_id')->nullable();
            $table->integer('skill_verb_id')->nullable();
            $table->integer('level')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('questions');
    }
};
