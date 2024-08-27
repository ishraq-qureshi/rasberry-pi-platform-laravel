<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rasberry_pis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_subscription_id');
            $table->string('pi_name');
            $table->string('model');
            $table->timestamps();

            $table->foreign('user_subscription_id')->references('id')->on('user_subscriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rasberry_pis');
    }
};
