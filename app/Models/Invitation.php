<?php

namespace App\Models;

use Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use App\Mail\Invitations\CompanyInvitation;
use App\Mail\Invitations\PropertyInvitation;

/**
 * App\Models\Invitation
 *
 * @method static Builder|Invitation newModelQuery()
 * @method static Builder|Invitation newQuery()
 * @method static Builder|Invitation query()
 * @mixin Eloquent
 * @property int $id
 * @property string $to email
 * @property string|null $name
 * @property string $invitation_type
 * @property array $invitation_target
 * @property Carbon $send_at
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property boolean $is_sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Invitation whereCreatedAt($value)
 * @method static Builder|Invitation whereId($value)
 * @method static Builder|Invitation whereInvitationTarget($value)
 * @method static Builder|Invitation whereInvitationType($value)
 * @method static Builder|Invitation whereIsSent($value)
 * @method static Builder|Invitation whereName($value)
 * @method static Builder|Invitation whereSendAt($value)
 * @method static Builder|Invitation whereTo($value)
 * @method static Builder|Invitation whereUpdatedAt($value)
 * @method static Builder|Invitation whereSentAt($value)
 * @method static Builder|Invitation notSent()
 * @method static Builder|Invitation maybeSendToday()
 */
class Invitation extends Model
{
    protected $fillable = [
        'to',
        'name',
        'invitation_type',
        'invitation_target',
        'send_at',
        'is_sent'
    ];

    protected $dates = [
        'send_at',
        'sent_at'
    ];

    protected $casts = [
        'is_sent' => 'bool',
        'invitation_target' => 'array',
    ];

    /**
     * @return Company[]|Property[]
     */
    public function properties(): array
    {
        $dataTargets = $this->invitation_target ?? [];
        $targets = [];
        $class = $this->computeInvitationType();

        foreach ($dataTargets as $target) {
            $targets [] = $class::find($target);
        }

        return $targets;
    }

    /**
     * @return Company
     */
    public function company()
    {
        if ($this->type(Company::class)) {
            return $this->properties()[0];
        }

        return $this->properties()[0]->company();
    }

    public function type($compare = null)
    {
        if ($compare) {
            return $this->computeInvitationType() === $compare;
        }

        return $this->computeInvitationType();
    }

    public function sendNotification(): void
    {
        if ($this->type(Company::class)) {
            \Mail::to($this->to)
                 ->send(new CompanyInvitation($this));
        }

        if ($this->type(Property::class)) {
            \Mail::to($this->to)
                 ->send(new PropertyInvitation($this));
        }

        if (app()->environment('production')) {
            $this->is_sent = true;
            $this->sent_at = now();
            $this->save();
        }

    }

    /**
     * Checks if send_at is today (or past date)
     *
     * @return bool
     */
    public function shouldSendToday(): bool
    {
        if ($this->is_sent || $this->sent_at !== null) {
            return false;
        }

        return $this->send_at->isToday() || $this->send_at->isPast();
    }

    public function scopeNotSent(Builder $query): Builder
    {
        return $query->where('is_sent', 0)
                     ->WhereNull('sent_at');
    }

    public function scopeMaybeSendToday(Builder $query): Builder
    {
        $yesterday = Carbon::yesterday()->toDateTimeString();
        $tomorrow = Carbon::tomorrow()->toDateTimeString();

        return $query->whereBetween('send_at', [$yesterday, $tomorrow]);
    }

    /**
     * Checks the 'invitation_type' column and returns the connected class.
     *
     * Defaults to property.
     *
     * @return string
     */
    private function computeInvitationType(): string
    {
        switch ($this->invitation_type) {
            case 'company':
            case Company::class:
                return Company::class;
            case 'property':
            case 'product':
            case Property::class:
            default:
                return Property::class;
        }
    }
}
