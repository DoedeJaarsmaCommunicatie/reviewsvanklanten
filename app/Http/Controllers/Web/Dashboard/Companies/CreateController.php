<?php

namespace App\Http\Controllers\Web\Dashboard\Companies;

use App\Models\Company;
use Illuminate\Support\Str;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    use requestFetchers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validateRequest($request);
        $company = new Company();
        $company->uuid = Str::uuid();

        $company->name = $this->getRequestValueOnKey($request, 'name');
        $company->description = $this->getRequestValueOnKey($request, 'description');
        $company->save();

        $company->users()->attach($request->user()->id);

        session()->flash('success', "Bedrijf {$company->name} is aangemaakt.");

        return back();
    }

    protected function validateRequest(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'bail'
                ],
                'description' => []
            ]
        );
    }
}
