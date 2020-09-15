@component('mail::message')
@isset($invitation->name)
Beste {{ $invitation->name }},
@else
Beste,
@endisset

Onlangs heb je bij {{ $company->name }} een bestelling geplaatst. Zij willen graag weten
wat ze goed hebben gedaan. Hiervoor willen wij jou vragen om jouw mening te delen over {{ $company->name }}.

@component('mail::button', [ 'url' => route('guest.review.company', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id]) ])
Jouw mening delen
@endcomponent

@component('mail::panel')
Heb je klachten of problemen met jouw bestelling, dan raden wij aan om dit rechtstreeks
met {{ $company->name }} op te nemen.
@endcomponent


Snel jouw mening delen over {{ $company->name }}?

<p style="text-align: center;">
<a href="{{ route('guest.review.company.create.quick', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 2]) }}"><img src="{{asset('images/rvk-star.png')}}" alt="1 ster" width="30" height="30"></a>
<a href="{{ route('guest.review.company.create.quick', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 4]) }}"><img src="{{asset('images/rvk-star.png')}}" alt="2 sterren" width="30" height="30"></a>
<a href="{{ route('guest.review.company.create.quick', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 6]) }}"><img src="{{asset('images/rvk-star.png')}}" alt="3 sterren" width="30" height="30"></a>
<a href="{{ route('guest.review.company.create.quick', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 8]) }}"><img src="{{asset('images/rvk-star.png')}}" alt="4 sterren" width="30" height="30"></a>
<a href="{{ route('guest.review.company.create.quick', [ 'id' => $company->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 10]) }}"><img src="{{asset('images/rvk-star.png')}}" alt="5 sterren" width="30" height="30"></a>
</p>

Met vriendelijke groet,

{{ $company->name }}<br>_via [reviewsvanklanten.nl](https://reviewsvanklanten.nl/)_
@endcomponent
