@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <x-components.alert type="status" class="alert--info" />
        <x-components.alert type="errors" class="alert--error" />

        <section class="lg:flex">
            @includeIf('partials.menu-user')

            <main class="lg:w-2/3 content">
                @if ($has_update)
                    <h1>Updates <small>(1)</small></h1>
                @else
                    <h1>Updates</h1>
                @endif

                @if ($has_update && \Auth::user()->can('update-app-version'))
                    <form method="POST" action="{{ route('admin.update') }}">
                        <h2>
                            Updaten van versie {{ $current_version }} naar versie {{ $new_version }}
                        </h2>
                        @csrf
                        @method('post')
                        <input type="hidden" value="{{ encrypt(\Auth::user()->id) }}" name="user" />

                        <button type="submit" class="pill bg-yellow-500 text-white">Updaten</button>
                    </form>

                @else
                    <p>De applicatie is volledig up-to-date.</p>
                @endif
            </main>
        </section>
    </div>
@endsection
