<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-secondary btn-sm" type="submit">Logout</button>
</form>
