<?php
    // echo password_hash('1234', PASSWORD_BCRYPT);
    // die;
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("../head.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $old = sanitize((int)$_POST["old"]);
        $new = sanitize((int)$_POST["new"]);
        $confirm = sanitize((int)$_POST["confirm"]);

        if ($new != $confirm) {
            $_SESSION['flash_error'] = "New PIN and Confirm PIN do not match.";
            redirect(PROOT . 'app/change-pin');
        }

        if (strlen($new) != 4) {
            $_SESSION['flash_error'] = "PIN must be 4 digits.";
            redirect(PROOT . 'app/change-pin');
        }

        if (!password_verify($old, $user_data['user_pin'])) {
            $_SESSION['flash_error'] = "Old PIN is incorrect.";
            redirect(PROOT . 'app/change-pin');
        }

        try {
            $pin_hash = password_hash($new, PASSWORD_BCRYPT);
            $statement = $dbConnection->prepare("UPDATE xpto_users SET user_pin = ?, pin = ? WHERE user_id = ?");
            $statement->execute([$pin_hash, $new, $user_id]);
            $_SESSION['flash_success'] = "PIN updated successfully.";
            redirect(PROOT . 'app/profile');
        } catch (PDOException $e) {
            $_SESSION['flash_error'] = "PIN update failed: " . $e->getMessage();
            redirect(PROOT . 'app/change-pin');
        }
    }

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
                            <a class="nav-link" href="<?= PROOT; ?>app/transactions">
                                <i class="bi-list nav-icon"></i> Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app/profile">
                                <i class="bi-person nav-icon"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= PROOT; ?>app/settings">
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

                                        <section class="card bg-light border-transparent mb-5" id="general">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-xl">
                                                            <img class="avatar-img" src="<?= PROOT; ?>assets/media/avatar.jpg" alt="...">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h2 class="fs-5 mb-0"> <?= (($user_data['user_firstname'] == null) ? 'Update your name to display here' : $user_name); ?> </h2>
                                                        <div class="text-dark"> Trader account </div>
                                                        <a href="<?= PROOT; ?>app/change-password">Change Password</a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form id="updatePIN" method="POST">
                                                    <div class="mb-4">
                                                        <div class="form-label">Change PIN</div>
                                                        <div class="mb-4">
                                                            <div class="form-label">Old PIN</div>
                                                            <input type="number" min="0" max="4" name="old" id="old" class="form-control" autocomplete="off" inputmode="numeric" data-maxlength="4" oninput="this.value=this.value.slice(0,this.dataset.maxlength)" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="form-label">New PIN</div>
                                                            <input type="number" min="0" max="4" name="new" id="new" class="form-control" autocomplete="off" inputmode="numeric" data-maxlength="4" oninput="this.value=this.value.slice(0,this.dataset.maxlength)" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-label">Confirm PIN</div>
                                                        <input type="number" min="0" max="4" name="confirm" id="confirm" class="form-control" autocomplete="off" inputmode="numeric" data-maxlength="4" oninput="this.value=this.value.slice(0,this.dataset.maxlength)" required>
                                                    </div>
                                                    <button type="button" id="submitForm" class="btn btn-warning">Change</button>
                                                </form>
                                            </div>
                                        </section>
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
		$(document).ready(function() {
            $('#submitForm').click(function() { 

                $('#submitForm').attr('disabled', true);
                $('#submitForm').html('Updating...');
                setTimeout(() => {
                    $('#updatePIN').submit();
                }, 3000);
            })
        })
	</script>
