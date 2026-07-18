<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('name');
            $table->boolean('krk_verified')->default(false)->after('hourly_rate');
            $table->timestamp('krk_verified_at')->nullable()->after('krk_verified');
            $table->string('krk_document_path')->nullable()->after('krk_verified_at');
        });

        Schema::table('cleaning_jobs', function (Blueprint $table) {
            $table->decimal('start_latitude', 10, 8)->nullable()->after('started_at');
            $table->decimal('start_longitude', 11, 8)->nullable()->after('start_latitude');
            $table->decimal('end_latitude', 10, 8)->nullable()->after('completed_at');
            $table->decimal('end_longitude', 11, 8)->nullable()->after('end_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'krk_verified', 'krk_verified_at', 'krk_document_path']);
        });

        Schema::table('cleaning_jobs', function (Blueprint $table) {
            $table->dropColumn(['start_latitude', 'start_longitude', 'end_latitude', 'end_longitude']);
        });
    }
};
