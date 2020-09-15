@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="lg:flex ">
            <main class="lg:w-2/3 content">
                <h1>
                    Plaats een review voor {{ $company->name }}
                </h1>
                <form method="POST" action="{{ route('guest.review.company', [ 'id' => $company->uuid ]) }}">
                    @csrf
                    @method('POST')
                    <div class="text-control">
                        <label for="email">E-mailadres</label>
                        <input type="email" value="{{ $email?? '' }}" name="email" id="email" />
                    </div>
                    <div class="text-control">
                        <label for="remarks">Opmerkingen</label>
                        <textarea id="remarks" name="remarks"></textarea>
                    </div>

                    <div class="text-control">
                        <label for="score">Score</label>
                        <span class="score-input"></span>
                        <noscript>
                            <input type="number" name="score" id="score">
                        </noscript>
                    </div>

                    <button type="submit" class="pill bg-primary-800 text-black">
                        Opsturen
                    </button>
                </form>
            </main>
        </section>
    </div>
@endsection
