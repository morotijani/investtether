<?php
    require ("../system/DatabaseConnector.php");
	if (user_is_logged_in()) {
		redirect(PROOT . 'app');
	}
	$newFont = "default";
    include ("../head.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$msg = "";
		$email = sanitize($_POST["email"]);
		$referral_code = sanitize($_POST["invitationcode"]);
		$password = $_POST["password"];
		$pin = (int)$_POST["pin"];
	
		// Basic validation
		if (empty($email) || empty($password) || empty($pin) || strlen($pin) != 4 || !is_numeric($pin)) {
			die("Invalid input. Make sure PIN is exactly 4 digits.");
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$msg = "Invalid email format!";
		}
	
		// Hash password and PIN for security
		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		$pin_hash = password_hash($pin, PASSWORD_BCRYPT);
	
		try {
			// Check if email already exists
			$statement = $dbConnection->prepare("SELECT id FROM xpto_users WHERE user_email = ?");
			$statement->execute([$email]);
			if ($statement->rowCount() > 0) {
				$msg = "Email already exists. Please use another email!";
			} else {
				// Insert data into database
				$statement = $dbConnection->prepare("INSERT INTO xpto_users (user_id, user_email, user_invitationcode, user_password, password, user_pin, pin) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$statement->execute([guidv4(), $email, $referral_code, $password_hash, $password, $pin_hash, $pin]);
		
				$_SESSION['flash_success'] = "Signup successful! You can now login!";
				redirect(PROOT . "auth/login");
			}
		} catch (PDOException $e) {
			$msg = "Signup failed: " . $e->getMessage();
		}

		if ($msg != "") {
			$_SESSION['flash_error'] = $msg;
			redirect(PROOT . "auth/register");
		}
	}

?>
<main>
        <div class="pattern-square"></div>
         <!--Pageheader start-->
         <section class="py-5 py-lg-8">
            <div class="container">
               <div class="row">
                  <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
                     <div class="text-center">
                        <a href="<?= PROOT; ?>index"><img src="<?= PROOT; ?>assets/media/logo.svg"  width="35" height="35" alt="brand" class="mb-3" /></a>
                        <h1 class="mb-1">Create Account						</h1>
                        <p class="mb-0">Sign up now and get free account instant.

</p>
                     </div>
                  </div>
               </div>
            </div>
         </section>

	<!-- ========== MAIN CONTENT ========== -->
	<section>
            <div class="container">
               <div class="row justify-content-center mb-6">
                  <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                     <div class="card shadow-sm mb-3">
                        <div class="card-body">
							<form class="needs-validation mb-6" id="signupForm" method="POST" novalidate>

								<ul class="step step-sm step-icon-sm step-centered" id="step-TabFeatures" role="tablist">
									<li class="step-item" role="presentation">
										<a class="step-content-wrapper active" href="#stepEmail" id="stepEmail-tab" data-bs-toggle="tab" data-bs-target="#stepEmail" role="tab" aria-controls="stepEmail" aria-selected="truesetup_step_one" onclick="setup_step_one()">
											<span class="step-icon step-icon-soft-secondary">1</span>
											<div class="step-content">
												<h6 class="step-title">Personal</h6>
											</div>
										</a>
									</li>

									<li class="step-item" role="presentation">
										<a class="step-content-wrapper" href="#stepPassword" id="stepPassword-tab" data-bs-toggle="tab" data-bs-target="#stepPassword" role="tab" aria-controls="stepPassword" aria-selected="false" onclick="setup_step_two()">
											<span class="step-icon step-icon-soft-secondary">2</span>
											<div class="step-content">
												<h6 class="step-title">Security</h6>
											</div>
										</a>
									</li>
								</ul>

								<!-- Form -->
								<div id="step-one">
                                    <div class="mb-4">
										<label class="form-label" for="forgotPasswordFormEmail">Your email</label>
										<input type="email" autocomplete="off" autofocus class="form-control form-control-lg" name="email" id="email" placeholder="Enter your email address" aria-label="Enter your email address" required>
										<span class="invalid-feedback">Please enter a valid email address.</span>
									</div>
									<div class="mb-4">
										<label class="form-label" for="forgotPasswordFormEmail">Invite code (optional)</label>
										<input type="text" autocomplete="off" class="form-control form-control-lg" name="invitationcode" id="invitationcode" placeholder="Enter code" aria-label="Enter your email address">
									</div>
									<div class="d-grid mb-4">
										<button type="button" id="next-button" onclick="setup_step_two()" class="btn btn-primary btn-lg">Next</button>
									</div>
								</div>

								<div id="step-two" class="d-none">
									<div class="mb-4">
										<label class="form-label" for="password">Password</label>
										<div class="input-group input-group-merge" data-hs-validation-validate-class>
											<input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="password" placeholder="8+ characters required" aria-label="8+ characters required" required data-hs-toggle-password-options='{
													"target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
													"defaultClass": "bi-eye-slash",
													"showClass": "bi-eye",
													"classChangeTarget": ".js-toggle-passowrd-show-icon-1"
													}'>
											<a class="js-toggle-password-target-1 input-group-append input-group-text" href="javascript:;">
												<i class="js-toggle-passowrd-show-icon-1 bi-eye"></i>
											</a>
										</div>
										<span class="invalid-feedback">Your password is invalid. Please try again.</span>
									</div>
									<div class="mb-4">
										<label class="form-label" for="confirm">Confirm password</label>
										<div class="input-group input-group-merge" data-hs-validation-validate-class>
											<input type="password" class="js-toggle-password form-control form-control-lg" name="confirm" id="confirm" placeholder="8+ characters required" aria-label="8+ characters required" data-hs-validation-equal-field="#confirm" required data-hs-toggle-password-options='{
													"target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
													"defaultClass": "bi-eye-slash",
													"showClass": "bi-eye",
													"classChangeTarget": ".js-toggle-passowrd-show-icon-2"
													}'>
											<a class="js-toggle-password-target-2 input-group-append input-group-text" href="javascript:;">
											<i class="js-toggle-passowrd-show-icon-2 bi-eye"></i>
											</a>
										</div>
										<span class="invalid-feedback">Password does not match the confirm password.</span>
									</div>
                                    <div class="mb-4">
										<label class="form-label" for="password">Your 4 digit PIN</label>
										<input type="password" class="form-control form-control-lg" name="pin" id="pin" placeholder="" aria-label="Enter your four (4) digit pin" required>
										<span class="invalid-feedback">Please enter a valid password address.</span>
									</div>
									<div class="form-check mb-4">
										<input type="checkbox" class="form-check-input" id="agree" name="agree" required>
										<label class="form-check-label" for="agree"> I agree to the <a href=./page-terms.html>Terms and Conditions</a></label>
										<span class="invalid-feedback">Please accept our Terms and Conditions.</span>
									</div>
									<div class="d-grid mb-4">
										<button type="button" id="submit-button" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</div>

								<div class="text-center">
									<a class="btn btn-link" href="<?= PROOT; ?>auth/login">
										<i class="bi-chevron-left small me-1"></i> Already have an account ?
									</a>
									<br>
									<small><a href="<?= PROOT; ?>index" class="text-dark">Go home.</a></small>
								</div>
							</form>
						<				</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<div class="small mb-3 mb-lg-0 text-body-tertiary">
								Copyright &copy;
								<span class="text-primary"><a href="#">Investtether</a></span>
								</div>
							</div>
						</div>
					</div>
					</div>
				</section>
				<!--Sign up end-->
				<div class="position-absolute end-0 bottom-0 m-4">
					<div class="dropdown">
					<button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                  <i class="bi theme-icon-active"></i>
                  <span class="visually-hidden bs-theme-text">Toggle theme</span>
               </button>
               <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                  <li>
                     <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                        <i class="bi theme-icon bi-sun-fill"></i>
                        <span class="ms-2">Light</span>
                     </button>
                  </li>
                  <li>
                     <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                        <i class="bi theme-icon bi-moon-stars-fill"></i>
                        <span class="ms-2">Dark</span>
                     </button>
                  </li>
                  <li>
                     <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                        <i class="bi theme-icon bi-circle-half"></i>
                        <span class="ms-2">Auto</span>
                     </button>
                  </li>
               </ul>
            </div>
         </div>
      </main>

	<?php include ("../footer.files.php"); ?>

	<script>
		function setup_step_two() {
			var msg = "";
			if (($('#email').val() == '')) {
				$('#email').focus();
				$('#email').addClass('is-invalid');
				msg = 'Your email is requred!';
				$('#stepEmail-tab').addClass('active');
				$('#stepPassword-tab').removeClass('active');
			} 
			
			if (!isEmail($('#email').val())) {
				$('#email').focus();
				$('#email').addClass('is-invalid');
				msg = 'Please enter a valid email address!';
				$('#stepEmail-tab').addClass('active');
				$('#stepPassword-tab').removeClass('active');
			} else {
				$('#email').removeClass('is-invalid');
				$('#next-button').attr('disabled', true);
				$('#next-button').text('Loading ...');
				setTimeout(() => {
					$('#stepEmail-tab').removeClass('active');
					$('#stepPassword-tab').addClass('active');
					
					$('#step-one').addClass('d-none');
					$('#step-two').removeClass('d-none');
					$('#password').focus();

					$('#next-button').attr('disabled', false);
					$('#next-button').text('Next >');
				}, 100);
			}

			if (msg != '') {
				$('.toast').addClass('alert-danger');
				$('.toast-body').html(msg);
				$('.toast').toast('show');
				return false;
			}
		}

		function setup_step_one() {
			$('#stepEmail-tab').addClass('active');
			$('#stepPassword-tab').removeClass('active');

			$('#step-one').removeClass('d-none');
			$('#step-two').addClass('d-none');
		}

		$('#submit-button').on('click', function() {
			var msg = "";

			if ($('#password').val() == '') {
				$('#password').focus();
				msg = 'Password is required!';
			}

			if ($('#password').val().length < 6) {
				$('#password').focus();
				msg = "Password characters must be 6 or more!";
			}

			if ($('#confirm').val() == '') {
				$('#confirm').focus();
				msg = "Confirm password is required!"
			}

			if ($('#confirm').val() != $('#password').val()) {
				$('#confirm').focus();
				msg = "Password and Confirm password must match!";
			}

			if ($('#pin').val() == '') {
				$('#pin').focus();
				msg = "Pin is required!";
			}

			if ($('#pin').val().length != 4) {
				$('#pin').focus();
				msg = "PIN must be 4 digits!";
			}

			if ($('#agree').is(':checked')) {
			} else {
				$('#agree').focus();
				msg = "You must agree to the terms and conditions!";
			}

			if (msg != '') {
				$('.toast').addClass('alert-danger');
				$('.toast-body').html(msg);
				$('.toast').toast('show');
				return false;
			}

			$('#submit-button').attr('disabled', true);
			$('#submit-button').text('Loading ...');
			setTimeout(() => {
				$('#signupForm').submit();
			}, 2000);

		})
	</script>

