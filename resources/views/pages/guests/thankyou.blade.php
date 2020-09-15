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
                    Bedankt voor het achterlaten van jouw review!
                </h1>
            </main>
        </section>
    </div>
@endsection
