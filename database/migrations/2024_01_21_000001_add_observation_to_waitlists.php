<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Refactoring SPMB - Update Waitlists Table
     * Menambah field untuk observasi
     */
    public function up(): void
    {
        Schema::table('waitlists', function (Blueprint $table) {
            // Observation fields
            $table->datetime('observation_date')->nullable()->after('notes');
            $table->text('observation_notes')->nullable()->after('observation_date');
            
            // Update status to support new flow
            // waiting -> scheduled -> passed -> failed -> transferred
        });
    }

    public function down(): void
    {
        Schema::table('waitlists', function (Blueprint $table) {
            $table->dropColumn(['observation_date', 'observation_notes']);
        });
    }
};
