<?php

namespace App\Console\Commands\Create;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class Users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-model:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively creates a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();

        $user->name = $this->ask('Name?');
        $user->email = $this->ask('Email?');
        $user->password = Hash::make($this->secret('Password?'));

        $this->line('Account data passed. Now for user information');

        $user->address = $this->ask('Address');
        $user->zipcode = $this->ask('Zip Code');
        $user->city = $this->ask('City');
        $user->phone  = $this->ask('Phone');

        $user->flags = [];

        $this->table(['name', 'email'], [[$user->name, $user->email]]);

        $this->table(['address', 'zipcode', 'city', 'phone'], [[$user->address, $user->zipcode, $user->city, $user->phone]]);

        if (!$this->confirm('Is data correct?', 1)) {
            $this->error('Incorrect input. Try again.');
            return 0;
        }

        $user->save();

        $this->line($user->name . ' has been saved to the database.');
        return $user->id;
    }
}
