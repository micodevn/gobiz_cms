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
        Schema::create('question_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->nullable();
            $table->string('group_parent')->nullable();
            $table->string('attribute')->nullable();
            $table->text('value')->nullable();
            $table->string('type')->nullable();
            $table->string('type_option')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_attributes');
    }
};
