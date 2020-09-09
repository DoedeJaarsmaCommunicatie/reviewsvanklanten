@php
    /** @var \App\Models\Review $review */
@endphp
<article class="review" {{ $attributes }}>
    <aside class="score">
        <span class="score--float">
            {{ $review->score }}
        </span>

    </aside>
    <main class="review__content">
        @isset($review->remarks)
            <div class="content">
                {{ $review->remarks }}
            </div>
        @endisset
        <footer>
            @isset($review->name)
            {{ $review->name }}
            @else
                <abbr title="{{$review->email}}">Anoniem</abbr>
            @endisset
        </footer>
    </main>
</article>
