<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
<<<<<<< HEAD
use Illuminate\Support\Facades\Schedule;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
<<<<<<< HEAD

Schedule::command('maintenance:generate')->monthlyOn(1, '00:00');
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
