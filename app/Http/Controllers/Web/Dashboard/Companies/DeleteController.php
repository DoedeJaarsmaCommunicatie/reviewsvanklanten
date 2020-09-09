<?php

namespace App\Http\Controllers\Web\Dashboard\Companies;

use App\Models\Company;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteController extends Controller
{
    use requestFetchers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fromOverview(Request $request)
    {
        if (!$this->hasRequestKey($request, 'company_id')) {
            session()->flash('errors', 'Geen bedrijf geselecteerd.');
            return back();
        }

        try {
            $company = $this->getCompany($this->getRequestValueOnKey($request, 'company_id'));
        } catch (ModelNotFoundException $exception) {
            session()->flash('errors', 'Bedrijf niet gevonden.');
            return back();
        }

        try {
            $company->delete();
        } catch (\Exception $e) {
            session()->flash('errors', $e->getMessage());
            return back();
        }

        return back()->with('success', 'Bedrijf verwijderd');
    }

    public function fromSingle(string $id)
    {
        try {
            $company = $this->getCompany($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('errors', 'Bedrijf niet gevonden.');
            return back();
        }

        try {
            $company->delete();
        } catch (\Exception $e) {
            session()->flash('errors', $e->getMessage());
            return back();
        }


        return back()->with('success', 'Bedrijf verwijderd');
    }

    private function getCompany($id)
    {
        return Company::findOrFail($id);
    }
}
