<?php
    require ("../system/DatabaseConnector.php");
    if (!admin_is_logged_in()) {
        admin_login_redirect();
    }

    // list all users
    $statement = $dbConnection->prepare("SELECT user_id, user_firstname, user_lastname, user_email FROM xpto_users ORDER BY createdAt DESC");
    $statement->execute();
    $users = $statement->fetchAll();
    $user_count = $statement->rowCount();
    $userOption = '';
    foreach ($users as $user) {
        $name = ucwords($user['user_firstname'] . ' ' . $user['user_lastname']);
        if ($user['user_firstname'] == null) {
            $name = $user['user_email'];
        }
        $userOption .= '<option value="' . $user['user_id'] . '">' . $name . '</option>';
    }

    // list crypto
    if (is_array($coin_data)) {
        if (isset($coin_data['data'])) {
            $cryptoOption = '';
            foreach (array_slice($coin_data['data'], 0, 5) as $crypto) {
                $cryptoOption .= '<option value="' . $crypto['id'] . '/' .$crypto['symbol'] . '/' . $crypto['name'] . '/' . number_format($crypto['quote']['USD']['price'], 2) . '">' . $crypto['name'] . '(' . $crypto['symbol'] . ')</option>';
            }
        }
    } else {
        $cryptoOption = "Error fetching data.";
    }

    // post transaction
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $msg = "";
      
        $user_id = sanitize($_POST['selectuser']);
        $send_amount = sanitize($_POST["amount"]);
        $to_cypto = sanitize($_POST["selectcrypto"]);
        $to_wallet_address = sanitize($_POST["wallet"]);
        $note = sanitize($_POST["note"]);
        $dt = sanitize($_POST['dt']);

        // get crypto details from $to_crypto
        $breakdown = explode("/", $to_cypto);
        $to_cypto_id = $breakdown[0];
        $to_crypto_symbol = $breakdown[1];
        $to_crypto_name = $breakdown[2];
        $to_crypto_price = $breakdown[3];

        if (empty($send_amount) || empty($to_cypto) || empty($to_wallet_address)) {
            $msg = "All fields are required.";
        }

        try {
            if (empty($msg) || $msg == "") {
                // Send crypto
                $statement = $dbConnection->prepare("INSERT INTO xpto_transactions (transaction_id, transaction_by, transaction_amount, transaction_crypto_id, transaction_crypto_symbol, transaction_crypto_name, transaction_crypto_price, transaction_to_address, transaction_message, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $statement->execute([
                    guidv4(), 
                    $user_id, 
                    $send_amount, 
                    $to_cypto_id, 
                    $to_crypto_symbol, 
                    $to_crypto_name, 
                    $to_crypto_price, 
                    $to_wallet_address, 
                    $note, 
                    $dt
                ]);
                $_SESSION['flash_success'] = "Transaction successful.";
                redirect(PROOT . 'xd192/TRANSACTIONS');
            }

        } catch (PDOException $e) {
            $msg = "Transaction failed: " . $e->getMessage();
        }

        if (!empty($msg) || $msg != "") {
            $_SESSION['flash_error'] = $msg;
            redirect(PROOT . 'xd192/TRANSACTIONS');
        }
    }

?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="<?= PROOT; ?>xd192/dist/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · Xpto</title>
    <link href="<?= PROOT; ?>xd192/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <meta name="theme-color" content="#712cf9">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
    
    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= PROOT; ?>xd192/dist/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#sun-fill"></use></svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em"><use href="#circle-half"></use></svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>
                </button>
            </li>
        </ul>
    </div>


    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Xpto</a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                    <i class="bi bi-search"></i>
                </button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
            </li>
        </ul>

        <div id="navbarSearch" class="navbar-search w-100 collapse">
            <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Xpto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="<?= PROOT; ?>xd192/">
                                <i class="bi bi-house-fill"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="<?= PROOT; ?>xd192/new.transaction">
                                <i class="bi bi-plus-circle"></i>
                                New Transaction
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="<?= PROOT; ?>xd192/TRANSACTIONS">
                                <i class="bi bi-arrow-left-right"></i>
                                Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="<?= PROOT; ?>xd192/USERS">
                                <i class="bi bi-people-fill"></i>
                                Users
                            </a>
                        </li>
                    </ul>
                    <hr class="my-3">
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="<?= PROOT; ?>xd192/settings">
                                <i class="bi bi-gear-wide-connected"></i>
                                Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="<?= PROOT; ?>xd192/logout">
                                <i class="bi bi-door-closed"></i>
                                Sign out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add transactions</h1>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="selectuser" class="form-label">Select user</label>
                    <select type="text" class="form-control" id="selectuser" name="selectuser" required>
                        <option value=""></option>
                        <?= $userOption; ?>
                    </select>
                    <div id="" class="form-text">Select user for this transaction.</div>
                </div>
                <div class="mb-3">
                    <label for="selectcrypto" class="form-label">Select crypto</label>
                    <select type="text" class="form-control" id="selectcrypto" name="selectcrypto" required>
                        <option value=""></option>
                        <?= $cryptoOption; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (USD)</label>
                    <input type="number" min="0" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="mb-3">
                    <label for="wallet" class="form-label">To wallet address</label>
                    <input type="text" class="form-control" id="wallet" name="wallet" required>
                    <div id="" class="form-text">Provide the wallet address you want to make the transaction to.</div>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="dt" class="form-label">Datetime:</label>
                    <input type="datetime-local" id="dt" name="dt" value="<?= date("Y-m-d H:m:s"); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </main>
    </div>

    <!-- TOAST MESSAGES -->
    <div class="toast-container translate-middle-x position-fixed start-50 bottom-0 end-0 p-3"> 
        <div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body"></div>
        </div>
    </div>

    <?= $flash_user; ?>

    <script src="<?= PROOT; ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= PROOT; ?>xd192/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $("#temporary").fadeOut(5000);

        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                $('.toast').addClass('bg-info');
				$('.toast-body').html("Copied to clipboard:" + text);
				$('.toast').toast('show');
                console.log("Copied to clipboard:", text);
            }).catch(err => {
                console.error("Failed to copy:", err);
            });
        }

        // TRANSACTION details modal
        function detailsmodal(id, i) {
            var data = {"id" : id}
            $.ajax ({
                url : "<?= PROOT; ?>xd192/details.modal.php",
                method : "POST",
                data : data,
                beforeSend: function() {
                    $('#details_'+i).attr('disabled', true)
                    $('#details_'+i).html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span role="status">Loading...</span>`);
                },
                success: function(data) {
                    $('body').append(data);
                    $('#details-modal').modal('toggle');
                    $('#details_'+i).attr('disabled', false)
                    $('#details_'+i).html('Details');
                },
                error: function(data) {
                    alert('Something went wrong.');
                    return false;
                }
            })
        }
    </script>
</body>
</html>
