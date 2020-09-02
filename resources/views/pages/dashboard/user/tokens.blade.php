@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @includeWhen($user->tokens->count() > 0, 'partials.users.token-overview')

        <form action="{{ route('dashboard.token.create') }}" method="POST">
            @csrf
            @method('post')
            <div class="text-control">
                <label for="name">Token naam</label>
                <input type="text" name="name" id="name" placeholder="Token naam">
                <small>
                    Geef de token een duidelijke naam voor eigen overzicht.
                </small>
            </div>
            <button class="pill bg-primary-800 text-white">
                Token aanmaken
            </button>
        </form>
    </div>
@endsection
