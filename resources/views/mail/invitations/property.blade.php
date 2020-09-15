@component('mail::message')
@isset($invitation->name)
Beste {{ $invitation->name }},
@else
Beste,
@endisset

Onlangs heb je bij {{ $company->name }} een bestelling geplaatst. Zij willen graag weten
wat ze goed hebben gedaan. Hiervoor willen
wij jou vragen om jouw mening te delen over jouw bestelde producten bij{{ $company->name }}.

@component('mail::panel')
Heb je klachten of problemen met jouw bestelling, dan raden wij aan om dit rechtstreeks
met {{ $company->name }} op te nemen.
@endcomponent

@foreach($properties as $property)
@component('mail::button', [ 'url' => route('guest.review.property', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id]) ])
Deel jouw mening over {{ $property->name }}
@endcomponent

<p style="text-align: center">Snel jouw mening delen over {{ $property->name }}?</p>

<p style="text-align: center;">
<a href="{{route('guest.review.property.create.quick', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 2])}}"><img src="{{asset('images/rvk-star.png')}}" alt="1 ster" width="30" height="30"></a>
<a href="{{route('guest.review.property.create.quick', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 4])}}"><img src="{{asset('images/rvk-star.png')}}" alt="2 sterren" width="30" height="30"></a>
<a href="{{route('guest.review.property.create.quick', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 6])}}"><img src="{{asset('images/rvk-star.png')}}" alt="3 sterren" width="30" height="30"></a>
<a href="{{route('guest.review.property.create.quick', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 8])}}"><img src="{{asset('images/rvk-star.png')}}" alt="4 sterren" width="30" height="30"></a>
<a href="{{route('guest.review.property.create.quick', [ 'id' => $property->uuid, 'email' => encrypt($invitation->to), 'encrypted' => true, 'invitation' => $invitation->id, 'score' => 10])}}"><img src="{{asset('images/rvk-star.png')}}" alt="5 sterren" width="30" height="30"></a>
</p>


@endforeach

Met vriendelijke groet,

{{ $company->name }}<br>_via [reviewsvanklanten.nl](https://reviewsvanklanten.nl/)_
@endcomponent
