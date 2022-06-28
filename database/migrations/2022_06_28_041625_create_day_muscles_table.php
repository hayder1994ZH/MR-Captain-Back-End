<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayMusclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_muscles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_day_id')->nullable();
            $table->unsignedBigInteger('muscle_id')->nullable();
            $table->string('gym_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();

            $table->foreign('gym_id')->references('uuid')->on('gyms')->onDelete('cascade');
            $table->foreign('muscle_id')->references('id')->on('muscles')->onDelete('cascade');
            $table->foreign('course_day_id')->references('id')->on('course_days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_muscles');
    }
}
