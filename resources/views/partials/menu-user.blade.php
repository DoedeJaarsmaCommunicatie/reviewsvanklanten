<nav class="nav-menu lg:w-1/3 mr-8">
    <h2>Menu</h2>
    <h3>Algemeen</h3>
    <a href="{{ route('home') }}">Dashboard</a>
    <a href="{{ route('dashboard.companies.overview') }}">Bedrijven</a>

    @if (isset($company))
        <h3>Properties</h3>
        <a href="{{ route('dashboard.properties.overview', ['id' => $company->uuid]) }}">
            Overzicht
        </a>
    @endif

    <h3>Instellingen</h3>
    <a href="{{ route('dashboard.tokens.overview') }}">Tokens</a>
</nav>
