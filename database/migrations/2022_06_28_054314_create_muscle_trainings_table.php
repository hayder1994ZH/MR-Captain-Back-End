<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMuscleTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muscle_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_muscle_id')->nullable();
            $table->unsignedBigInteger('training_id')->nullable();
            $table->unsignedBigInteger('push_id')->nullable();
            $table->string('gym_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();

            $table->foreign('gym_id')->references('uuid')->on('gyms')->onDelete('cascade');
            $table->foreign('push_id')->references('id')->on('pushes')->onDelete('cascade');
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->foreign('day_muscle_id')->references('id')->on('day_muscles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('muscle_trainings');
    }
}
