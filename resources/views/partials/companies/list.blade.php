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
            <th>Verwijderen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr>
                <td>
                    <a href="{{ route('dashboard.companies.single', $company->uuid) }}">
                        {{$company->uuid}}
                    </a>
                </td>
                <td>{{$company->name}}</td>
                <td>{{$company->averageScore()}}</td>
                <td>
                    <form action="{{ route('dashboard.company.delete') }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" value="{{$company->id}}" name="company_id" />
                        <button type="submit" class="pill bg-red-500 text-white">
                            Verwijderen
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
