<?php
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("header.app.php");

    // get all transactions
    $statement = $dbConnection->prepare("SELECT * FROM xpto_transactions WHERE transaction_by = ? ORDER BY createdAt DESC");
    $statement->execute([$user_id]);
    $transactions = $statement->fetchAll();
    $count_transactions = $statement->rowCount();

    // get ups and down
    $upsdown = '';
    if ($transactions['transaction_updown'] == 1) {
        $upsdown = '+'; 
    } else {
        $upsdown = '-'; 
    }

?>
    
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
                                                                    <span class="d-sm-block text-muted text-xs"><?= pretty_date_notime($transaction["createdAt"]) . ' <i>(' . timeAgo($createdAt) . ')</i>'; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-none d-md-block text-sm"><?= $shortened; ?></div>
                                                            <div class="d-none d-md-block">
                                                                <span class="badge bg-light text-<?= $status_text; ?>"><?= $status; ?></span>
                                                            </div>
                                                            <div class="text-end">
                                                                <span class="d-block text-heading text-sm fw-bold"><span class="badge bg-danger"><?= $upsdown; ?></span><?= money($transaction_amount) . ' ' . $crypto_symbol; ?> </span>
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
