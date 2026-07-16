<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cleaning_schedule_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('day_of_week'); // 0=nd, 1=pon, ..., 6=sob
            $table->time('start_time');
            $table->foreignId('default_employee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index(['location_id', 'day_of_week']);
        });

        Schema::create('cleaning_jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('status')->default('pending'); // pending | in_progress | completed | cancelled
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('uuid');
            $table->index(['employee_id', 'scheduled_date']);
            $table->index(['location_id', 'scheduled_date']);
            $table->index('scheduled_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cleaning_jobs');
        Schema::dropIfExists('cleaning_schedule_templates');
    }
};
