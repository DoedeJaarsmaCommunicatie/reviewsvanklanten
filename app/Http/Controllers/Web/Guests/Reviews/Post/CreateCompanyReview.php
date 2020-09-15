<?php

namespace App\Http\Controllers\Web\Guests\Reviews\Post;

use App\Models\Review;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Traits\requestFetchers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateCompanyReview extends Controller
{
    use requestFetchers;

    public function quickReview(Request $request, string $id)
    {
        return $this->createReview($request, $id);
    }

    public function showForm(Request $request, string $id)
    {
        if ($this->hasRequestKey($request, 'encrypted')) {
            $email = decrypt($this->getRequestValueOnKey($request, 'email'));
        } else {
            $email = $this->getRequestValueOnKey($request, 'email');
        }

        return \View::make('pages.guests.reviews.company')
            ->with(
                [
                    'company' => Company::whereUuid($id)->firstOrFail(),
                    'email' => $email,
                ]
            );
    }

    public function storeInvitation(Request $request, string $id)
    {
        return $this->createReview($request, $id);
    }

    /**
     * @param Request $request
     * @param string  $id
     *
     * @return \Illuminate\View\View
     */
    public function createReview(Request $request, string $id)
    {
        $company = Company::whereUuid($id)->firstOrFail();

        $review = new Review();
        $review->uuid = Str::uuid();

        if ($this->hasRequestKey($request, 'name')) {
            $review->name = $this->getRequestValueOnKey($request, 'name');
        }

        if ($this->hasRequestKey($request, 'remarks')) {
            $review->remarks = $this->getRequestValueOnKey($request, 'remarks');
        }

        if ($this->hasRequestKey($request, 'encrypted')) {
            $review->email = decrypt($this->getRequestValueOnKey($request, 'email'));
        } else {
            $review->email = $this->getRequestValueOnKey($request, 'email');
        }
        $review->score = $this->getRequestValueOnKey($request, 'score');
        $review->reviewable_type = Company::class;
        $review->reviewable_id = $company->id;

        if ($review->hasPassingGrade()) {
            $review->status = 'active';
        }

        $review->save();

        return view('pages.guests.thankyou');
    }
}
