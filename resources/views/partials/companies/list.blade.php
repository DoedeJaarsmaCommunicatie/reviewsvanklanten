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
                Reviewonderdelen
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>{{$company->uuid}}</td>
                <td>{{$company->name}}</td>
                <td>{{$company->properties()->count()}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
