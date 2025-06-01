    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-boxed mx-auto mt-lg-4">
                <a class="navbar-brand" href="<?= PROOT; ?>app/"><img src="<?= PROOT; ?>assets/media/logo.svg" width="35" height="35" /></a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#">twitter <i class="bi-twitter me-1"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">facebook <i class="bi-facebook me-1"></i></a>
                        </li>
                    </ul>
                    <div class="mt-3 mt-lg-0 d-flex align-items-center">
                        <a href="<?= PROOT; ?>auth/login" class="btn btn-light mx-2">Login</a>
                        <a href="<?= PROOT; ?>auth/register" class="btn btn-primary">Create account</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>