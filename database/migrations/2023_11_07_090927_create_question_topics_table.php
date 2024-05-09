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
        Schema::create('question_topics', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('topic_id');
        });

        Schema::table('question_topics', function($table) {
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->cascadeOnDelete();
        });

        Schema::table('question_topics', function($table) {
            $table->foreign('topic_id')
                ->references('id')
                ->on('topics')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_topics');
    }
};
