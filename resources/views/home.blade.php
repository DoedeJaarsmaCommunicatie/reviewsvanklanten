@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <section class="lg:flex ">
            @includeIf('partials.menu-user')

            <main class="lg:w-2/3">
                @if ($subscription_type)
                    <form action="{{ route('subscriptions.new') }}" method="POST">
                        @csrf
                        @method('post')
                        <select>
                            <option>Basis</option>
                            <option>Plus</option>
                            <option>Premium</option>
                        </select>
                        <button type="submit" class="pill bg-primary-800 text-black">Subscribe now</button>
                    </form>
                @endif

                @includeWhen($companies->count() > 0, 'partials.companies.list')
            </main>
        </section>
    </div>
@endsection
