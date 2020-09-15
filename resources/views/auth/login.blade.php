@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <x-components.alert type="errors" class="alert--error" />

        <h1 class="text-2xl text-center">Inloggen!</h1>
        <h3 class="subtitle text-center mb-8 text-sm text-gray-600">
            Nog geen account?
            <a href="{{ route('register') }}" class="text-primary">Registreer hier</a>
        </h3>
    </div>

    <div class="container mx-auto py-4 lg:flex">
        <div class="lg:w-1/2 mx-auto rounded shadow p-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @method('post')

                <div class="text-control my-2">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="text-control my-2">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') invalid @enderror" name="password" required autocomplete="current-password">
                </div>

                <div class="checkbox-control my-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div>
                    <button type="submit" class="btn border border-primary-500 bg-primary-500 text-white">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn border border-white text-primary-500 hover:border-primary-500 transition-all duration-300 ease-in-out" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
