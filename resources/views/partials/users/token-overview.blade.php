<table class="striped">
    <thead>
    <tr>
        <td>
            Token
        </td>
        <td>
            Intrekken
        </td>
    </tr>
    </thead>
    <tbody>
    @foreach($user->tokens as $token)
        <tr>
            <td>{{ $token->name }}</td>
            <td>
                <form action="{{ route('dashboard.token.delete') }}" method="POST">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="token_id" value="{{ $token->id }}">
                    <button type="submit" class="pill bg-red-500 text-white">Intrekken</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
