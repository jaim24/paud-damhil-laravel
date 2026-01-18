<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update waitlists status column to support new SPMB flow
     * Old: waiting, transferred, cancelled
     * New: waiting, scheduled, passed, failed, transferred, cancelled
     */
    public function up(): void
    {
        // Change ENUM to VARCHAR to support all status values
        DB::statement("ALTER TABLE waitlists MODIFY COLUMN status VARCHAR(50) DEFAULT 'waiting'");
    }

    public function down(): void
    {
        // Revert to old ENUM (will truncate data if new values exist)
        DB::statement("ALTER TABLE waitlists MODIFY COLUMN status ENUM('waiting', 'transferred', 'cancelled') DEFAULT 'waiting'");
    }
};
