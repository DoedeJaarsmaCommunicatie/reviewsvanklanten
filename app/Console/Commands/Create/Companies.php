<?php

namespace App\Console\Commands\Create;

use App\User;
use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Companies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-model:company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively creates a Company';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $company = new Company();
        $company->name = $this->ask('Name?');
        $company->description = $this->ask('Description?');
        $company->uuid = Str::uuid();


        $this->table(['name', 'description'], [[$company->name, $company->description]]);

        if (!$this->confirm('Is data correct?', 1)) {
            $this->line('Data incorrect.');
            return 0;
        }

        $company->save();
        $this->line($company->name . ' saved to database');

        if ($this->confirm('Connect to users?')) {
            $users = $this->ask('user id (separate with `,` for more than 1)');
            $users = explode(',', $users);
            array_map(function ($id) use ($company) {
                if (!User::whereId($id)->exists()) {
                    return;
                }
                if (User::find($id)->canCreateBusiness()) {
                    $company->users()->attach($id);
                } else {
                    $this->error('No more business for this user.');
                }
            }, $users);
        }

        if ($company->users()->count() === 0) {
            $company->forceDelete();
            $this->error('Company deleted. No owners available');
            return 0;
        }

        return $company->id;
    }
}
