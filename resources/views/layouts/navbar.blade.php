<nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Tes Aptavis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link {{ Route::is('clubs') ? 'active' : '' }}" href="{{ route('clubs') }}">Klub</a>
                <a class="nav-link {{ Route::is('scores') ? 'active' : '' }}" href="{{ route('scores') }}">Skor</a>
                <a class="nav-link {{ Route::is('leaderboards') ? 'active' : '' }}"
                    href="{{ route('leaderboards') }}">Klasemen</a>
            </div>
        </div>
    </div>
</nav>
