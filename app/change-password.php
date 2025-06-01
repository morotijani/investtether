<?php
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("../head.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $msg = "";
        $old = sanitize($_POST["old"]);
        $password = sanitize($_POST["password"]);
        $confirm = sanitize($_POST["confirm"]);

        if (empty($old) || empty($password) || empty($confirm)) {
            $msg = "All fields are required.";
        }

        if ($password != $confirm) {
            $msg = "Passwords do not match.";
        }

        if (strlen($password) < 6) {
            $msg = "Password must be at least 6 characters.";
        }

        if ($old == $password) {
            $msg = "New password must be different from the old password.";
        }

        try {
            // Check if the user exists
            $statement = $dbConnection->prepare("SELECT user_password FROM xpto_users WHERE user_id = ?");
            $statement->execute([$user_id]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($old, $user['user_password'])) {
                if (empty($msg) || $msg == "") {
                    // Update password
                    $statement = $dbConnection->prepare("UPDATE xpto_users SET user_password = ?, password = ? WHERE user_id = ?");
                    $statement->execute([password_hash($password, PASSWORD_BCRYPT), $password, $user_id]);
                    $_SESSION['flash_success'] = "Password updated successfully.";
                    redirect(PROOT . 'app/settings');
                }
            } else {
                $msg = "Invalid old password.";
            }

        } catch (PDOException $e) {
            $msg = "Password update failed: " . $e->getMessage();
        }

        if (!empty($msg) || $msg != "") {
            $_SESSION['flash_error'] = $msg;
            redirect(PROOT . 'app/change-password');
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
                                                        <a href="<?= PROOT; ?>app/change-pin">Change PIN</a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form id="updatePassword" method="POST">
                                                    <div class="mb-4">
                                                        <div class="form-label">Change your password</div>
                                                        <div class="mb-4">
                                                            <div class="form-label">Old password</div>
                                                            <input type="password" name="old" id="old" class="form-control" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="form-label">New password</div>
                                                            <input type="password" name="password" id="password" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-label">Confirm new password</div>
                                                        <input type="password" name="confirm" id="confirm" class="form-control" required>
                                                    </div>
                                                    <button type="button" id="submitForm" class="btn btn-danger">Change</button>
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
                $('#submitForm').html('Changing...');
                setTimeout(() => {
                    $('#updatePassword').submit();
                }, 3000);
            })
        })
	</script>
