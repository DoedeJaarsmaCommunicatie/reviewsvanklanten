@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if (!$subscription_type)
            <form action="{{ route('subscriptions.new') }}" method="POST">
                @csrf
                @method('post')
                <button type="submit" class="pill bg-primary-800 text-black">Subscribe now</button>
            </form>
        @endif

        @includeWhen($companies->count() > 0, 'partials.companies.list')
    </div>
@endsection
