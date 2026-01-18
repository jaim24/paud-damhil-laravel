<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update applicants status column to support new SPMB flow
     * Old: Pending, Accepted, Rejected
     * New: administrasi, declaration, payment, paid, accepted, rejected
     */
    public function up(): void
    {
        // Change ENUM to VARCHAR to support all status values
        DB::statement("ALTER TABLE applicants MODIFY COLUMN status VARCHAR(50) DEFAULT 'administrasi'");
    }

    public function down(): void
    {
        // Revert to old ENUM (will truncate data if new values exist)
        DB::statement("ALTER TABLE applicants MODIFY COLUMN status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending'");
    }
};
