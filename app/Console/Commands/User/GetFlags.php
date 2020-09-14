<?php

namespace App\Console\Commands\User;

use App\User;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetFlags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users-flag:get {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets all flags a user has.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $user = User::findOrFail($this->argument('user'));
        } catch (ModelNotFoundException $e) {
            $this->error("User with id `{$this->argument('user')}` not found");
            return 0;
        }

        $table = new Table($this->output);
        $table->setHeaders(['name']);

        foreach ($user->flags as $flag) {
            $table->addRow([$flag]);
        }

        $table->render();

        return 1;
    }
}
