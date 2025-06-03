<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>InvestTether</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= PROOT; ?>assets/media/logo.svg">
    
    <link rel="stylesheet" href="<?= PROOT; ?>assets/css/theme.min.css">
    
    <link rel="stylesheet" href="<?= PROOT; ?>assets/css/vendor.min.css">
    <link rel="stylesheet" href="<?= PROOT; ?>assets/css/other.css">
</head>
<body>

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
                                        <a class="@@company nav-link" href="<?= PROOT; ?>app/profile">Hi <?= $user_name; ?>!</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="@@support nav-link" href="<?= PROOT; ?>auth/logout">Logout
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Deposit</a>
                                    </li>
                                    <li class="nav-item mt-3 mt-lg-0">
                                        <a class="nav-link btn btn-primary btn-sm text-white" href="#">Withdraw</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
   