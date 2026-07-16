<?php

namespace App\Console\Commands;

use App\Models\CleaningJob;
use App\Models\CleaningScheduleTemplate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateWeeklyJobs extends Command
{
    protected $signature = 'app:generate-weekly-jobs';
    protected $description = 'Generuje zlecenia sprzątania na kolejne 7 dni na podstawie szablonów harmonogramów';

    public function handle(): int
    {
        $today = Carbon::today();
        $endDate = Carbon::today()->addDays(7);

        $templates = CleaningScheduleTemplate::with(['location', 'defaultEmployee'])
            ->whereHas('location', fn ($q) => $q->where('is_active', true))
            ->get();

        $generated = 0;
        $skipped = 0;

        for ($date = $today->copy(); $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek;

            $dayTemplates = $templates->filter(fn ($t) => $t->day_of_week === $dayOfWeek);

            foreach ($dayTemplates as $template) {
                $exists = CleaningJob::where('location_id', $template->location_id)
                    ->where('scheduled_date', $date->toDateString())
                    ->where('scheduled_time', $template->start_time)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                CleaningJob::create([
                    'uuid' => (string) Str::uuid(),
                    'location_id' => $template->location_id,
                    'employee_id' => $template->default_employee_id,
                    'scheduled_date' => $date->toDateString(),
                    'scheduled_time' => $template->start_time,
                    'status' => CleaningJob::STATUS_PENDING,
                ]);

                $generated++;
            }
        }

        $this->info("Wygenerowano {$generated} zleceń (pominięto {$skipped} istniejących).");
        $this->info("Zakres: {$today->toDateString()} → {$endDate->toDateString()}");

        return Command::SUCCESS;
    }
}
