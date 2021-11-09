<?php

namespace App\Console\Commands;

use App\Models\Feedback\Tenant;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Config;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup {--clean}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup all the sites';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->backupSystem();
        $sites = Tenant::all();
        foreach ($sites as $site) {
            $this->setupConfigForSite($site);
            $this->callBackupCommand();
        };
    }
    protected function backupSystem()
    {
        Config::set('backup.backup.source.databases', ['system']);
        Config::set('backup.backup.name', 'system-backup');
        $this->call('backup:run', ['--only-db']);
    }

    protected function setupConfigForSite(Tenant $website)
    {
        $connection = app(Connection::class);
        $connection->set($website);
        Config::set('backup.backup.source.databases', ['tenant']);
        Config::set('backup.backup.name', 'tenant-' . $website->uuid);
        Config::set('backup.backup.source.files.include', $this->siteIncludes($website));

    }


    protected function siteIncludes(Tenant $website)
    {
        return storage_path('app/tenancy/tenants/' . $website->uuid);
    }

    protected function callBackupCommand()
    {
        $this->call('backup:run');
    }
}
