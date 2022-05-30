<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGymIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('gym_id')->nullable()->after('status');
            $table->foreign('gym_id')->references('id')->on('gyms')->onDelete('cascade');
            $table->unsignedBigInteger('rule_id')->nullable()->after('gym_id');
            $table->foreign('rule_id')->references('id')->on('rules')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
