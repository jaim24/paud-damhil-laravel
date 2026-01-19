<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add authentication fields to teachers table for Flutter app login
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('id');
            $table->string('email')->nullable()->unique()->after('name');
            $table->string('password')->nullable()->after('email');
            $table->string('api_token', 80)->nullable()->unique()->after('password');
            $table->string('device_token')->nullable()->after('api_token'); // For push notifications
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'email', 
                'password',
                'api_token',
                'device_token',
                'last_login_at'
            ]);
        });
    }
};
