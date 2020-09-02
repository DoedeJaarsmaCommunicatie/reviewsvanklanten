<table class="striped">
    <thead>
        <tr>
            <th>
                <abbr title="ID">#</abbr>
            </th>
            <th>
                Naam
            </th>
            <th>
                Gemiddelde score
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>{{$company->uuid}}</td>
                <td>{{$company->name}}</td>
                <td>{{$company->averageScore()}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
