<?php

namespace App\Console\Commands\Admin;

use Illuminate\Console\Command;
use Codedge\Updater\UpdaterManager;

class UpdateApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the application';

    /**
     * @var UpdaterManager
     */
    protected $updater;

    /**
     * Create a new command instance.
     *
     * @param UpdaterManager $updater
     */
    public function __construct(UpdaterManager $updater)
    {
        parent::__construct();
        $this->updater = $updater;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->updater->source()->isNewVersionAvailable()) {
            $this->line('Current installed version: ' . $this->updater->source()->getVersionInstalled());

            $versionAvailable = $this->updater->source()->getVersionAvailable();

            $this->line('Updating to version: '. $versionAvailable);
            $release = $this->updater->source()->fetch($versionAvailable);

//            $this->updater->source()->update($release);
            \Artisan::call('admin:update-env SELF_UPDATER_VERSION_INSTALLED ' . $versionAvailable);
            $this->line('Updated to version: '. $versionAvailable);
            return 0;
        }

        $this->line('No update available.');

        return 0;
    }
}
