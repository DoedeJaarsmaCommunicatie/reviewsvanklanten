<?php

namespace App\Http\Controllers\Web\Dashboard\Properties;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OverviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, string $id)
    {
        /** @var User $user */
        $user = $request->user();

        return \View::make('pages.dashboard.properties.overview')
                    ->with(
                        [
                            'user' => $user,
                            'company' => $user->companies()->where('uuid', '=', $id)->first(),
                            'properties' => $user
                                ->companies()
                                ->where('uuid', '=', $id)
                                ->firstOrFail()->properties,
                        ]
                    );
    }
}
