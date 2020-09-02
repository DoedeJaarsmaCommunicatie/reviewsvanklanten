<?php

namespace App\Http\Controllers\Web\Subscribe;

use App\User;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class NewSubscription extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validateRequest($request);

        /** @var User $user */
        $user = \Auth::user();

        if (!$user->subscribed(User::T_B_SUB_NAME, $this->getSubscriptionType($request))) {
            $res = $user
                ->newSubscription(User::T_B_SUB_NAME, $this->getSubscriptionType($request))
                ->create();


            if (is_a($res, RedirectToCheckoutResponse::class)) {
                return $res;
            }

            return back()->with('status', 'You are now subscribed!');
        }


        return back()->with('status', 'You are already subscribed');
    }

    protected function getSubscriptionType(Request $request)
    {
        switch ($request->get('subscription_type')) {
            case 'basic':
                return User::T_B_BASIC_YEARLY;
            case 'plus':
                return User::T_B_PLUS_YEARLY;
            case 'pro':
                return User::T_B_PRO_YEARLY;
        }

        throw new BadRequestHttpException('Subscription type not passed');
    }

    protected function validateRequest(Request $request)
    {
        $request->validate(
            [
                'subscription_type' => [
                    'required',
                    'bail',
                    Rule::in(['basic', 'plus', 'pro'])
                ],
            ]
        );
    }
}
