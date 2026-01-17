<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->enum('spmb_status', ['open', 'closed', 'waitlist_only'])->default('closed')->after('mission');
            $table->integer('spmb_quota')->default(50)->after('spmb_status');
            $table->date('spmb_start_date')->nullable()->after('spmb_quota');
            $table->date('spmb_end_date')->nullable()->after('spmb_start_date');
            $table->text('spmb_closed_message')->nullable()->after('spmb_end_date');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['spmb_status', 'spmb_quota', 'spmb_start_date', 'spmb_end_date', 'spmb_closed_message']);
        });
    }
};
