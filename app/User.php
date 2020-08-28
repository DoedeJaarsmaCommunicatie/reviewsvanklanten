<?php

namespace App;

use Eloquent;
use App\Models\Company;
use Laravel\Cashier\Billable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Laravel\Cashier\Order\Contracts\ProvidesInvoiceInformation;

/**
 * App\User
 *
 * @property int                                                                                  $id
 * @property string                                                                               $name
 * @property string                                                                               $email
 * @property Carbon|null                                                      $email_verified_at
 * @property string                                                                               $password
 * @property string|null                                                                          $remember_token
 * @property Carbon|null                                                      $created_at
 * @property Carbon|null                                                      $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null                                                                        $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|Company[] $companies
 * @property-read int|null $companies_count
 * @property string $address
 * @property string $zipcode
 * @property string $city
 * @property string $phone
 * @property string|null $mollie_customer_id
 * @property string|null $mollie_mandate_id
 * @property string $tax_percentage
 * @property string|null $trial_ends_at
 * @property string|null $extra_billing_information
 * @property-read Collection|\Laravel\Cashier\Credit\Credit[] $credits
 * @property-read int|null $credits_count
 * @property-read \Laravel\Cashier\Order\OrderItemCollection|\Laravel\Cashier\Order\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Laravel\Cashier\Order\OrderCollection|\Laravel\Cashier\Order\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Laravel\Cashier\Coupon\RedeemedCouponCollection|\Laravel\Cashier\Coupon\RedeemedCoupon[] $redeemedCoupons
 * @property-read int|null $redeemed_coupons_count
 * @property-read Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereExtraBillingInformation($value)
 * @method static Builder|User whereMollieCustomerId($value)
 * @method static Builder|User whereMollieMandateId($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereTaxPercentage($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereZipcode($value)
 */
class User extends Authenticatable implements MustVerifyEmail, ProvidesInvoiceInformation
{
    use Notifiable;
    use Billable;

    public const T_B_BASIC_YEARLY = 'basic-yearly';
    public const T_B_PLUS_YEARLY = 'plus-yearly';
    public const T_B_PRO_YEARLY = 'pro-yearly';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Checks if a user has space for another business.
     *
     * @return bool
     */
    public function canCreateBusiness(): bool
    {
        switch($this->subscriptions) {
            case static::T_B_BASIC_YEARLY:
                return $this->companies()->count() < 1;
            case static::T_B_PLUS_YEARLY:
                return $this->companies()->count() < 3;
            case static::T_B_PRO_YEARLY:
                return $this->companies()->count() < 10;
            default:
                return app()->environment('production') ? false : true; # Return true for testing purposes
        }
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function getInvoiceInformation()
    {
        return [$this->name, $this->email];
    }

    public function getExtraBillingInformation()
    {
        return null;
    }
}
