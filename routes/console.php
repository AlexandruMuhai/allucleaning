<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:generate-weekly-jobs')->dailyAt('06:00');
