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
        Schema::table('rasberry_pis', function (Blueprint $table) {
            $table->dropColumn('model');
            $table->unsignedBigInteger('rasberry_pi_model_id');
            $table->foreign('rasberry_pi_model_id')->references('id')->on('rasberry_pi_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rasberry_pis', function (Blueprint $table) {
            $table->dropColumn('rasberry_pi_model_id'); // Drop the column if the migration is rolled back
        });
    }
};
