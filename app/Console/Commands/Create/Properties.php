<?php

namespace App\Console\Commands\Create;

use App\Models\Company;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Properties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-model:property';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively creates a property';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $property = new Property();
        $property->name = $this->ask('Name?');
        $property->description = $this->ask('Description?');
        $property->uuid = Str::uuid();
        $parent_type = $this->choice(
            'Parent type',
            [Property::class, Company::class],
            'property',
            2
        );
        $property->parent_type = $parent_type;
        $property->parent_id = $this->ask('Parent ID');

        if (!$property->parent()->exists()) {
            $this->error('Parent does not exist');
        }

        $this->table(
            ['name', 'description', 'parent name'],
            [[$property->name, $property->description, $property->parent->name]]
        );

        if (!$this->confirm('Is data correct?')) {
            $this->line('Data incorrect!');
            return 0;
        }

        $property->save();
        return $property->id;
    }
}
