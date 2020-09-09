@extends('layouts.app')

@php
/**
 * @var \App\User $user
 */
@endphp

@section('header/title')
    <title>
        Reviews van klanten | {{ $user->name }}
    </title>
@endsection

@section('content')
    <div class="container mx-auto">
        <x-components.alert type="success" class="alert--success" />
        <x-components.alert type="errors" class="alert--error" />

        <section class="lg:flex ">
            @includeIf('partials.menu-user')

            <main class="lg:w-2/3">
                @includeWhen($user->companies->count() > 0, 'partials.companies.list', ['companies' => $user->companies])

                @includeWhen($user->canCreateBusiness(), 'partials.users.company-create')
            </main>
        </section>
    </div>
@endsection
