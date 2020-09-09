<h2>Toevoegen nieuw bedrijf</h2>

<form action="{{ route('dashboard.company.create') }}" method="POST">
    @csrf
    @method('post')
    <div class="text-control">
        <label for="name">Bedrijfsnaam</label>
        <input type="text" name="name" id="name" placeholder="Bedrijfsnaam">
        <small>Geef de bedrijfsnaam op.</small>
    </div>

    <div class="text-control">
        <label for="description">Omschrijving</label>
        <input type="text" name="description" id="description" placeholder="Omschrijving" />
        <small>Geef een korte omschrijving van jouw bedrijf op. Deze is zichtbaar op de review pagina.</small>
    </div>

    <button type="submit" class="pill bg-primary-800 text-white">
        Bedrijf aanmaken
    </button>
</form>
