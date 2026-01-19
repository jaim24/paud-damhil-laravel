<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add payment info fields to settings table
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('spmb_closed_message');
            $table->string('bank_account')->nullable()->after('bank_name');
            $table->string('bank_holder')->nullable()->after('bank_account');
            $table->decimal('registration_fee', 12, 2)->nullable()->after('bank_holder');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'bank_name',
                'bank_account',
                'bank_holder',
                'registration_fee',
            ]);
        });
    }
};
