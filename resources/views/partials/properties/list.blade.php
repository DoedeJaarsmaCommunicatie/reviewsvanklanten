<table class="striped">
    <thead>
    <tr>
        <th>
            <abbr title="ID">#</abbr>
        </th>
        <th>Naam</th>
        <th>Gemiddelde Score</th>
    </tr>
    </thead>
    <tbody>
    @isset($properties)
        @foreach($properties as $property)
            @php
            /** @var \App\Models\Property $property */
            @endphp
            <tr>
                <td>
                    <a>{{ $property->uuid }}</a>
                </td>
                <td>
                    {{ $property->name }}
                </td>
                <td>
                    {{ $property->averageScore() }}
                </td>
            </tr>
        @endforeach
    @else
        <p>Niks gevonden.</p>
    @endisset
    </tbody>
</table>
