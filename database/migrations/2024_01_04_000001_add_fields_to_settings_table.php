<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('school_name')->default('PAUD Damhil UNG')->after('id');
            $table->string('logo')->nullable()->after('school_name');
            $table->string('email')->nullable()->after('contact_phone');
            $table->text('about')->nullable()->after('contact_address');
            $table->text('vision')->nullable()->after('about');
            $table->text('mission')->nullable()->after('vision');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['school_name', 'logo', 'email', 'about', 'vision', 'mission']);
        });
    }
};
