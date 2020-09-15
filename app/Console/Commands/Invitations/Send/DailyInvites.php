<?php

namespace App\Console\Commands\Invitations\Send;

use App\Models\Company;
use App\Models\Property;
use App\Models\Invitation;
use Illuminate\Console\Command;
use App\Mail\Invitations\CompanyInvitation;
use App\Mail\Invitations\PropertyInvitation;

class DailyInvites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitations-send:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the invitations scheduled for today';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $invitations = Invitation::notSent()->maybeSendToday()->get();

        foreach ($invitations as $invitation) {
            if ($invitation->shouldSendToday()) {
                $invitation->sendNotification();
            }
        }

        return 0;
    }
}
