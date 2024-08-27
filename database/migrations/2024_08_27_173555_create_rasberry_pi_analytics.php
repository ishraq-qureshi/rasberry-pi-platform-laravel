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
        Schema::create('rasberry_pi_analytics', function (Blueprint $table) {
            $table->id();
            $table->string("serial_number");
            $table->string("cpu_usage");
            $table->string("ram_usage");
            $table->string("temperature");
            $table->string("model");
            $table->string("ip_address_lan");
            $table->string("ip_address_wlan");
            $table->string("storage_usage");
            $table->string("last_update");
            $table->string("disk_usage_total");
            $table->string("disk_usage_used");
            $table->unsignedBigInteger('rasberry_pi_id');

            $table->foreign('rasberry_pi_id')->references('id')->on('rasberry_pis')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rasberry_pi_analytics');
    }
};
