<?php

namespace App\Console\Commands\Admin;

use Illuminate\Console\Command;

class UpdateEnvValue extends Command
{
    protected $whitelist = [
        'SELF_UPDATER_VERSION_INSTALLED',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update-env {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Modify an env value to something else';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->isWhitelisted()) {
            $this->warn('Key is not in whitelist. ABORT');
            return 0;
        }

        $key = $this->argument('key');
        $value = $this->argument('value');
        $current = env($key);

        $this->line('Current value: ' . $current);

        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            file_put_contents($envFile, str_replace(
                "{$key}={$current}",
                "{$key}={$value}",
                file_get_contents($envFile)
            ));
        }

        $this->line('New value: ' . $key . '=' . $value);

        return 0;
    }

    private function isWhitelisted()
    {
        return in_array($this->argument('key'), $this->whitelist, true);
    }
}
