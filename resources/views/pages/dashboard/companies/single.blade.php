@extends('layouts.app')

@section('header/title')
    <title>
        Reviews van klanten | {{ $company->name }}
    </title>
@endsection

@section('content')
    <div class="container mx-auto">
        <x-components.alert type="success" class="bg-green-700 text-green-100 p-4" />

        <section class="lg:flex ">
            @includeIf('partials.menu-user')

            <main class="lg:w-2/3">
                <div class="content">
                    <h1>Profiel van {{ $company->name }}</h1>

                    <p>{!! $company->description !!}</p>
                </div>

                <div class="company__reviews--latest">
                    @foreach($company->latestReviews() as $review)
                        <x-tease.review :review="$review" />
                    @endforeach
                </div>

                <div class="company__reviews--invite">
                    <form method="POST" action="#">
                        @csrf
                        @method('post')
                        <div class="text-control">
                            <label for="email">E-mailadres</label>
                            <input type="email" name="email" id="email" placeholder="naam@voorbeeld.nl" />
                            <small>De uitnodiging wordt naar dit adres gestuurd</small>
                        </div>
                        <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">

                        <button type="submit" class="pill bg-green-800 text-green-100">
                            Uitnodigen
                        </button>
                    </form>
                </div>
            </main>
        </section>
    </div>
@endsection
