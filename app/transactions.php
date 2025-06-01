<?php
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("../head.php");

    // get all transactions
    $statement = $dbConnection->prepare("SELECT * FROM xpto_transactions WHERE transaction_by = ? ORDER BY createdAt DESC");
    $statement->execute([$user_id]);
    $transactions = $statement->fetchAll();
    $count_transactions = $statement->rowCount();

?>

<link rel="stylesheet" href="<?= PROOT; ?>assets/css/fonts/themes.min.css">
<link rel="stylesheet" href="<?= PROOT; ?>assets/css/fonts/app.css">
    <header id="header" class="navbar navbar-expand-lg navbar-light navbar-end bg-white">
        <div class="container">
            <nav class="js-mega-menu navbar-nav-wrap">
                <a class="navbar-brand" href="<?= PROOT; ?>app/" aria-label="Space">
                    <img class="navbar-brand-logo" src="<?= PROOT; ?>assets/media/logo.svg" width="35" height="35" alt="Image Description">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-default">
                        <i class="bi-list"></i>
                    </span>
                    <span class="navbar-toggler-toggled">
                        <i class="bi-x"></i>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="hs-has-mega-menu nav-item">
                            <a id="landingsMegaMenu" class="nav-link" aria-current="page" href="#" role="button" aria-expanded="false"><i class="bi-twitter me-1"></i></a>
                        </li>
                        <li class="hs-has-mega-menu nav-item">
                            <a id="landingsMegaMenu" class="nav-link" aria-current="page" href="#" role="button" aria-expanded="false"><i class="bi-facebook me-1"></i></a>
                        </li>

                        <li class="hs-has-mega-menu nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app/profile">Hi <?= $user_name; ?>!</a>
                        </li>
                        <li class="hs-has-mega-menu nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>auth/logout">Logout</a>
                        </li>
                    
                        <li class="nav-divider"></li>

                        <li class="nav-item">
                            <a class="js-animation-link btn btn-ghost-secondary btn-no-focus me-2 me-lg-0" href="<?= PROOT; ?>auth/login">Deposit</a>
                            <a class="js-animation-link d-lg-none btn btn-primary" href="<?= PROOT; ?>auth/register">
                                <i class="bi-sign-turn-slight-right me-1"></i> Withdraw
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="js-animation-link d-none d-lg-inline-block btn btn-primary" href="<?= PROOT; ?>auth/register">
                                <i class="bi-sign-turn-slight-right me-1"></i> Withdraw
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    
	<!-- ========== MAIN CONTENT ========== -->
	<main id="content" role="main">
		<div class="bg-soft-primary-light">
            <div class="container content-space-1 ">


                <div class="row g-3 g-xl-6 mb-4">
                    <div class="col-12">
                        <div class="vstack gap-3 gap-xl-6">
                            <div class="d-flex">
                                <div class="">
                                    <div class="hstack gap-3 mb-1">
                                        <h4 class="fw-semibold">Total Balance</h4>
                                        <a href="javascript:;" onclick="toggleBalance()">
                                            <i class="bi bi-eye view-hide-balance"></i> 
                                        </a>
                                        <a href="javascript:;">
                                            <i class="bi bi-info-circle"></i>
                                        </a>
                                    </div>
                                    <div class="text-2xl text-heading fw-bolder ls-tight blurred" id="balance"><?= money($user_data['user_balance']); ?></div>
                                </div>
                                <div class="ms-auto align-self-end">
                                    <a href="javascript:;" class="btn btn-sm btn-light mb-2" data-bs-toggle="modal" data-bs-target="#receiveModal" href="javascript:;">Receive crypto</a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

				<div class="mx-auto">
                    <!-- Nav -->
                    <ul class="nav nav-segment d-flex justify-content-between">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app">
                                <i class="bi-house nav-icon"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app/">
                                <i class="bi-send-check-fill nav-icon"></i> Send Crypto
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= PROOT; ?>app/transactions">
                                <i class="bi-list nav-icon"></i> Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app/profile">
                                <i class="bi-person nav-icon"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app/settings">
                                <i class="bi-sliders nav-icon"></i> Settings
                            </a>
                        </li>
                    </ul>
                    <!-- End Nav -->
					<div class="card card-lg zi-2">
                        <!-- Features Step -->
                        <div class="overflow-hidden">
                            <div class="container content-space-b-1 content-space-b-md-3 mt-4">
                                <div class="row">
                                    <div class="col-md-12 order-md-2 mb-7 mb-md-0">
                                        <!-- Transactions -->
                                        <div class="card">
                                            <div class="card-body pb-0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5>Transaction History</h5>
                                                    </div>
                                                    <div class="hstack align-items-center">
                                                        <a href="<?= PROOT; ?>app/transactions" class="text-muted">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="list-group list-group-flush">

                                                <?php 
                                                    if (is_array($transactions) && $count_transactions > 0): 
                                                        foreach ($transactions as $transaction): 
                                                            $crypto_id = $transaction['transaction_crypto_id'];
                                                            $crypto_name = $transaction['transaction_crypto_name'];
                                                            $crypto_symbol = $transaction['transaction_crypto_symbol'];
                                                            $crypto_price = $transaction['transaction_crypto_price'];
                                                            $createdAt = $transaction['createdAt'];
                                                            $transaction_amount = $transaction['transaction_amount'];
                                                            $transaction_status = $transaction['transaction_status'];

                                                            $transaction_to_address = $transaction['transaction_to_address'];
                                                            $shortened = shortenStringMiddle($transaction_to_address, 28);

                                                            $icon = "https://s2.coinmarketcap.com/static/img/coins/64x64/{$crypto_id}.png";

                                                            $status = '';
                                                            $status_text = '';
                                                            if ($transaction_status == 0) {
                                                                $status = 'Pending';
                                                                $status_text = 'warning';
                                                            } elseif ($transaction_status == 1) {
                                                                $status = 'Successful';
                                                                $status_text = 'success';
                                                            } else {
                                                                $status = 'Canceled';
                                                                $status_text = 'danger';
                                                            }

                                                ?>


                                                        <div class="list-group-item d-flex align-items-center justify-content-between gap-6">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="icon icon-shape rounded-circle icon-sm flex-none w-rem-10 h-rem-10 text-sm bg-primary bg-opacity-25 text-primary">
                                                                    <img src="<?= $icon; ?>" class="w-rem-6 h-rem-6 rounded-circle img-fluid" alt="..."> 
                                                                </div>
                                                                <div class="">
                                                                    <span class="d-block text-heading text-sm fw-semibold"><?= $crypto_name; ?> </span>
                                                                    <span class="d-none d-sm-block text-muted text-xs"><?= timeAgo($createdAt); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-none d-md-block text-sm"><?= $shortened; ?></div>
                                                            <div class="d-none d-md-block">
                                                                <span class="badge bg-light text-<?= $status_text; ?>"><?= $status; ?></span>
                                                            </div>
                                                            <div class="text-end">
                                                                <span class="d-block text-heading text-sm fw-bold"><?= money($transaction_amount) . ' ' . $crypto_symbol; ?> </span>
                                                                <span class="d-block text-muted text-xs"><?= '$' . $crypto_price; ?></span>
                                                            </div>
                                                        </div>

                                                        <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="alert alert-secondary">No data available.</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<!-- Shape -->
		<div class="shape-container">
			<div class="shape shape-bottom zi-1">
				<svg viewBox="0 0 3000 600" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 600V350.234L3000 0V600H0Z" fill="#fff" />
				</svg>
			</div>
		</div>

   	</main>
    
    <?php include ("../footer.php"); ?>
	<?php include ("../footer.files.php"); ?>
	<script>
		
	</script>
