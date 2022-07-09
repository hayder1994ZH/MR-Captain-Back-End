<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsGymsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions_gyms', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_whatsapp')->default(0);
            $table->boolean('is_sms')->default(0);
            $table->string('start_date')->nullable();
            $table->string('expair_date')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->string('gym_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();

            $table->foreign('gym_id')->references('uuid')->on('gyms')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('cards_gyms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions_gyms');
    }
}
