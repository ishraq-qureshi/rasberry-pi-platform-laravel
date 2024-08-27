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
        Schema::create('rasberry_pi_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rasberry_pi_id');
            $table->foreign('rasberry_pi_id')->references('id')->on('rasberry_pis')->onDelete('cascade');
            $table->string("value");
            $table->enum('type', ['cpu', 'storage', 'ram', 'temperature']);
            $table->enum('status', ['ideal', 'warning', 'danger']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rasberry_pi_notifications');
    }
};
