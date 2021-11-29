<?php

namespace App\Console;

use App\Models\Feedback\Tenant;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        foreach (Tenant::all() as $tenant) {
//            $schedule->command('tenants:run backup:run  --tenants=' . $tenant->id )->everyMinute();
//        }
        $schedule->exec('php artisan backup:run && php artisan tenants:run backup:run' . $this->getTenants())->everyMinute()->runInBackground()->withoutOverlapping();
        $schedule->exec('users:notify')->everyFiveMinutes()->runInBackground()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected function getTenants()
    {
        return Cache::remember('tenants-ids', now()->addHour(), function () {
            $str = '';
            foreach (Tenant::get()->pluck('id')->all() as $id) {
                $str .= " --tenants='{$id}'";
            }

            return $str;
        });
    }
}
