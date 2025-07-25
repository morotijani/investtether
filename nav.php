    <!--====================== Preloader Start ======================-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--====================== Preloader End ======================-->

    <!--====================== Header Start ======================-->
    <header class="header sticky-top bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- <div class="navigation navigation-2"> -->
                    <div class="navigation">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <a class="navbar-brand" href="<?= PROOT; ?>"><img src="<?= PROOT; ?>assets/media/logo.svg" width="35" height="35" loading="lazy" alt="…">
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="active nav-link" href="<?= PROOT; ?>">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="@@wallet nav-link" href="<?= PROOT; ?>wallet">Wallet</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="@@company nav-link" href="#">About us
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="@@support nav-link" href="#">Support
                                        </a>
                                    </li>
                                    <?php if (user_is_logged_in()): ?>
                                        <li class="nav-item">
                                            <a class="nav-link btn btn-primary btn-sm text-white" href="<?= PROOT; ?>app/">Dashboard</a>
                                        </li>
                                        <?php else: ?>
                                            <li class="nav-item">
                                            <a class="nav-link" href="<?= PROOT; ?>auth/register">Register</a>
                                        </li>
                                        <li class="nav-item mt-3 mt-lg-0">
                                            <a class="nav-link btn btn-primary btn-sm text-white" href="<?= PROOT; ?>auth/login">Sign in</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--====================== Header end ======================-->
