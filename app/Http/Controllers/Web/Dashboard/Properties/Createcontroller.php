<?php

namespace App\Http\Controllers\Web\Dashboard\Properties;

use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Createcontroller extends Controller
{
    use requestFetchers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        session()->flash('warnings', 'Functionality not implemented yet.');
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
                'description' => [],
            ]
        );
    }
}
