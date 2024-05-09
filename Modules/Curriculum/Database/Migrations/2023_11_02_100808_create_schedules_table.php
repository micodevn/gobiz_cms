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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('content')->comment('Thông tin hiển thị ngày hoặc giờ');
            $table->string('values')->comment('Giá trị ngày hoặc giờ');
            $table->unsignedBigInteger('course_id')->nullable()->comment('ID khoá học');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('Trạng thái (0: Khoá; 1: Kích hoạt)');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
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
        Schema::dropIfExists('schedules');
    }
};
