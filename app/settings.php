<?php
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("header.app.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $msg = "";
        $fname = sanitize($_POST["fname"]);
        $lname = sanitize($_POST["lname"]);
        $email = sanitize($_POST["email"]);
        $phone = sanitize($_POST["phone"]);

        if (empty($fname) || empty($lname) || empty($email)) {
            $msg = "All fields are required.";
        }
        
        try {
            if (empty($msg) || $msg == "") {
                $statement = $dbConnection->prepare("UPDATE xpto_users SET user_firstname = ?, user_lastname = ?, user_email = ?, user_phone = ? WHERE user_id = ?");
                $statement->execute([$fname, $lname, $email, $phone, $user_id]);
                $_SESSION['flash_success'] = "Profile updated successfully.";
                redirect(PROOT . 'app/settings');
            }
        } catch (PDOException $e) {
            $msg = "Profile update failed: " . $e->getMessage();
        }

        if (!empty($msg) || $msg != "") {
            $_SESSION['flash_error'] = $msg;
            redirect(PROOT . 'app/settings');
        }
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
                                                        <a href="<?= PROOT; ?>app/change-password">Change password</a>
                                                    </div>
                                                </div>
                                                <hr>
                                                <form id="updateProfile" method="POST">
                                                    <div class="mb-4">
                                                        <div class="form-label">Update Profile details</div>
                                                        <div class="mb-4">
                                                            <div class="form-label">First name</div>
                                                            <input type="text" name="fname" id="fname" class="form-control" value="<?= ((isset($_POST['fname']) && !empty($_POST['fname'])) ? $_POST['fname'] : $user_data['user_firstname']); ?>" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <div class="form-label">Last name</div>
                                                            <input type="text" name="lname" id="lname" class="form-control" value="<?= ((isset($_POST['lname']) && !empty($_POST['lname'])) ? $_POST['lname'] : $user_data['user_lastname']); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-label">Email</div>
                                                        <input type="email" name="email" id="email" class="form-control" value="<?= ((isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : $user_data['user_email']); ?>" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-label">Phone</div>
                                                        <input type="phone" name="phone" id="phone" class="form-control" value="<?= ((isset($_POST['phone']) && !empty($_POST['phone'])) ? $_POST['phone'] : $user_data['user_phone']); ?>">
                                                    </div>
                                                    <button type="button" id="submitForm" class="btn btn-dark">Update</button>
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
                    $('#updateProfile').submit();
                    // $('#submitForm').attr('disabled', false);
                    // $('#submitForm').html('Update');
                }, 3000);
                // var fname = $('#fname').val();
                // var lname = $('#lname').val();
                // var email = $('#email').val();
                // var phone = $('#phone').val();
                // var data = {
                //     fname: fname,
                //     lname: lname,
                //     email: email,
                //     phone: phone
                // }
                // $.ajax({
                //     url: '<?= PROOT; ?>app/update-profile',
                //     type: 'POST',
                //     data: data,
                //     success: function(response) {
                //         console.log(response);
                //     }
                // })
            })
        })
	</script>
