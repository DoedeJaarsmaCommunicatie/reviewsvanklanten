<?php

namespace App\Mail\Invitations;

use App\Models\Company;
use App\Models\Property;
use App\Models\Invitation;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyInvitation extends Mailable
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
     * @var Property[]
     */
    public $properties = [];

    /**
     * Create a new message instance.
     *
     * @param Invitation $invitation
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
        $this->company = $invitation->company();

        $this->properties = $invitation->properties();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $companyName = $this->company->name;

        return $this
            ->from('noreply@reviewsvanklanten.nl',  $companyName . ' via Reviews van Klanten')
            ->subject($companyName . ' zou het waarderen als je een review achter laat.')
            ->markdown('mail.invitations.property');
    }
}
