<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cleaning_jobs', function (Blueprint $table) {
            $table->unsignedInteger('scheduled_duration_minutes')->default(120)->after('scheduled_time');
        });
    }

    public function down(): void
    {
        Schema::table('cleaning_jobs', function (Blueprint $table) {
            $table->dropColumn('scheduled_duration_minutes');
        });
    }
};
