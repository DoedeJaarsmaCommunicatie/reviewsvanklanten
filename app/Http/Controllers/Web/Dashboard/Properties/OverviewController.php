<?php

namespace App\Http\Controllers\Web\Dashboard\Properties;

use App\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            /** @var Company  $company */
            $company = $user->companies()->where('uuid', '=', $id)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            session()->flash('errors', 'Company not found');
            return back();
        }

        return \View::make('pages.dashboard.properties.overview')
                    ->with(
                        [
                            'user' => $user,
                            'company' => $company,
                            'properties' => $company->properties,
                        ]
                    );
    }
}
