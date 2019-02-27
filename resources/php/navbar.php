<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php?mod=show&op=display">Kontollarte</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?mod=user&op=displayAccount">Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?mod=picture&op=displayPictures">Paintings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?mod=gallery&op=getFirstGalleries&view-type=first-galleries">Galleries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?mod=message&op=displayMessages">Messages</a>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav mr-auto" id="log-out-item">
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Log out
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="index.php?mod=user&op=login">Close session</a>
            </div>
        </li>
    </ul>
</nav>