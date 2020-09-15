<?php

namespace App\Mail\Invitations;

use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyInvitation extends Mailable
{
    use SerializesModels;

    /**
     * @var Invitation
     */
    public $invitation;

    /**
     * @var Company
     */
    public $company;

    /**
     * Create a new message instance.
     *
     * @param Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
        // A company should get only one property item.
        $this->company = $invitation->company();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $companyName = $this->company->name;

        return $this
            ->from('noreply@reviewsvanklanten.nl',  $companyName . ' via Reviews van Klanten')
            ->subject($companyName . ' zou het waarderen als je een review achter laat.')
            ->markdown('mail.invitations.company');
    }
}
