<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->foreignId('client_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            $table->string('type')->default('office')->after('name'); // office | staircase
            $table->integer('area_sqm')->nullable()->after('address');
            $table->text('access_code')->nullable()->after('area_sqm');
            $table->text('cleaning_instructions')->nullable()->after('access_code');
            $table->string('schedule_info')->nullable()->after('cleaning_instructions');
            $table->boolean('is_active')->default(true)->after('schedule_info');

            // client_name zastąpione przez client_id
            $table->dropColumn('client_name');

            $table->index('uuid');
            $table->index('client_id');
            $table->index('type');
            $table->index('is_active');
        });

        // Wypełnij uuid dla istniejących rekordów
        \Illuminate\Support\Facades\DB::table('locations')
            ->whereNull('uuid')
            ->get()
            ->each(function ($loc) {
                \Illuminate\Support\Facades\DB::table('locations')
                    ->where('id', $loc->id)
                    ->update(['uuid' => (string) \Illuminate\Support\Str::uuid()]);
            });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
            $table->dropIndex(['client_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['is_active']);

            $table->dropForeign(['client_id']);
            $table->dropColumn([
                'uuid',
                'client_id',
                'type',
                'area_sqm',
                'access_code',
                'cleaning_instructions',
                'schedule_info',
                'is_active',
            ]);
            $table->string('client_name')->nullable();
        });
    }
};
