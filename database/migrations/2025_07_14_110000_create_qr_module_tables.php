<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_passports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamp('next_scheduled_clean')->nullable();
            $table->timestamps();

            $table->index('uuid');
        });

        Schema::create('clean_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_passport_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('cleaned_at');
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('cleaned_at');
        });

        Schema::create('issue_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_passport_id')->constrained()->onDelete('cascade');
            $table->string('reporter_name')->nullable();
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('status')->default('pending'); // pending | processing | resolved
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            $table->string('resolution_photo_path')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issue_reports');
        Schema::dropIfExists('clean_logs');
        Schema::dropIfExists('qr_passports');
    }
};
