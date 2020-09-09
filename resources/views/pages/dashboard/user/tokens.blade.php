@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <x-components.alert type="status" class="alert--info" />

        <section class="lg:flex">
            @includeIf('partials.menu-user')

            <main class="lg:w-2/3">
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
            </main>
        </section>


    </div>
@endsection
