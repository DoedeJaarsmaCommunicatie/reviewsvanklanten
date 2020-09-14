<?php

namespace App\Console\Commands\User;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddFlag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users-flag:add {user} {flag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a flag to a user';

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

        try {
            $flags = $user->flags;
            $flags []= Str::slug($this->argument('flag'));

            $user->flags = $flags;
            $user->saveOrFail();
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            $this->error('Flag not added');
            return 0;
        }

        $this->line("Flag `{$this->argument('flag')}` added to `{$this->argument('user')}`");
        return 1;
    }
}
