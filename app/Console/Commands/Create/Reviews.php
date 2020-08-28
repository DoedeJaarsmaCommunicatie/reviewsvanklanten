<?php

namespace App\Console\Commands\Create;

use App\Models\Review;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class Reviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-model:review';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively creates a review';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $review = new Review();
        $review->name = $this->ask('Name?', '');
        $review->score = $this->ask('Score (use `.` as decimal separator)', 1.0);
        $review->remarks = $this->ask('Any remarks?');
        $review->uuid = Str::uuid();
        $review->reviewable_type = $this->choice('Review target type', [
            Property::class, Company::class
        ]);
        $review->reviewable_id = $this->ask('Review target ID');
        if (!$review->reviewable()->exists()) {
            $this->error('Review target does not exist.');
            return 0;
        }
        $this->table(['score', 'remarks', 'property'], [[$review->score, $review->remarks, $review->reviewable()->name]]);

        if (!$this->confirm('Is data correct?', 1)) {
            $this->error('Data incorrect.');
            return 0;
        }

        $review->save();

        $this->line('Review added for: ' . $review->property->name);
        return $review->id;
    }
}
