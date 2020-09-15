@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-4">
        <x-components.alert type="errors" class="alert--error" />

        <h1 class="text-2xl text-center">Registreer vandaag nog!</h1>
        <h3 class="subtitle text-center mb-8 text-sm text-gray-600">Geen betaalgegevens nodig.</h3>
    </div>

    <div class="container mx-auto py-4 lg:flex">
        <div class="lg:w-1/2 mx-auto rounded shadow p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                @method('post')

                <div class="text-control my-2">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>

                <div class="text-control my-2">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>

                <div class="text-control my-2">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') invalid @enderror" name="password" required autocomplete="new-password">
                </div>

                <div class="text-control my-2">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div>
                    <button type="submit" class="btn border border-primary-500 bg-primary-500 text-white">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
