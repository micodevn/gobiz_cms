<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->unsignedInteger('position')->nullable();
            $table->unsignedBigInteger('type')->comment('Loại buổi học');
            $table->tinyInteger('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('stage_id')
                ->references('id')
                ->on('stages')
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
        Schema::dropIfExists('lessons');
    }
};
