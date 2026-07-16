<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // qr_passports: name -> zone_name
        Schema::table('qr_passports', function (Blueprint $table) {
            $table->renameColumn('name', 'zone_name');
        });

        // clean_logs: dodaj location_id, qr_passport_id nullable
        Schema::table('clean_logs', function (Blueprint $table) {
            $table->foreignId('location_id')->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('qr_passport_id')->nullable()->change();
        });

        // issue_reports: dodaj location_id, qr_passport_id nullable
        Schema::table('issue_reports', function (Blueprint $table) {
            $table->foreignId('location_id')->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('qr_passport_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('issue_reports', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->foreignId('qr_passport_id')->nullable(false)->change();
        });

        Schema::table('clean_logs', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
            $table->foreignId('qr_passport_id')->nullable(false)->change();
        });

        Schema::table('qr_passports', function (Blueprint $table) {
            $table->renameColumn('zone_name', 'name');
        });
    }
};
