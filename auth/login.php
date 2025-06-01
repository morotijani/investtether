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
		$password = $_POST["password"];

		if (empty($email) || empty($password)) {
			$msg = "Email and password are required.";
		}

		try {
			// Check if the user exists
			$statement = $dbConnection->prepare("SELECT user_id, user_password FROM xpto_users WHERE user_email = ?");
			$statement->execute([$email]);
			$user = $statement->fetch(PDO::FETCH_ASSOC);

			if ($user && password_verify($password, $user['user_password'])) {
				// Login successful
				if (empty($msg) || $msg == "") {
					$user_id = $user['user_id'];
					userLogin($user_id);
				}
			} else {
				$msg = "Invalid email or password.";
			}

		} catch (PDOException $e) {
			$msg = "Login failed: " . $e->getMessage();
		}

		if (!empty($msg) || $msg != "") {
			$_SESSION['flash_error'] = $msg;
			redirect(PROOT . 'auth/login');
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
                        <h1 class="mb-1">Welcome Back</h1>
                        <p class="mb-0">
                           Don’t have an account yet?
                           <a href="<?= PROOT; ?>auth/register" class="text-primary">Register here</a>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </section>

		 <section>
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                     <div class="card shadow-sm mb-6">
                        <div class="card-body">
						   <form class="js-validate needs-validation mb-6" id="loginForm" method="POST" novalidate>

									<ul class="step step-sm step-icon-sm step-centered" id="step-TabFeatures" role="tablist">
										<li class="step-item" role="presentation">
											<a class="step-content-wrapper active" href="#stepEmail" id="stepEmail-tab" data-bs-toggle="tab" data-bs-target="#stepEmail" role="tab" aria-controls="stepEmail" aria-selected="true">
												<span class="step-icon step-icon-soft-secondary">1</span>
												<div class="step-content">
													<h6 class="step-title">Email</h6>
												</div>
											</a>
										</li>

										<li class="step-item" role="presentation">
											<a class="step-content-wrapper" href="#stepPassword" id="stepPassword-tab" onclick="stepPassword()" data-bs-toggle="tab" data-bs-target="#stepPassword" role="tab" aria-controls="stepPassword" aria-selected="false">
												<span class="step-icon step-icon-soft-secondary">2</span>
												<div class="step-content">
													<h6 class="step-title">Secrete keys</h6>
												</div>
											</a>
										</li>
									</ul>

									<!-- Form -->
									<div id="step-one">
										<div class="mb-4">
											<label class="form-label" for="email">Your email</label>
											<input type="email" autocomplete="off" class="form-control form-control-lg" name="email" id="email" placeholder="Enter your email address" aria-label="Enter your email address" required>
											<span class="invalid-feedback">Please enter a valid email address.</span>
										</div>

										<div class="d-grid mb-4">
											<button type="button" id="next-button" onclick="stepPassword()" class="btn btn-primary btn-lg">Next</button>
										</div>
									</div>

									<div id="step-two" class="d-none">
										<div class="mb-4">
											<label class="form-label" for="password">Your Password</label>
											<input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="***" aria-label="Enter your password" required>
											<span class="invalid-feedback">Please enter a valid password address.</span>
										</div>

										<div class="d-grid mb-4">
											<button type="button" id="submit-button" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</div>


									<div class="text-center">
										<small><a href="<?= PROOT; ?>index" class="text-dark">Go home.</a></small>
									</div>

								</form>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="text-center">
								<div class="small mb-3 mb-lg-0 text-body-tertiary">
								Copyright &copy;
								<span class="text-primary"><a href="#">BitShell</a></span>
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
		$(document).ready(function() {
		})
		
		$('#stepEmail-tab').on('click', function(e) {

			$('#stepEmail-tab').addClass('active');
			$('#stepPassword-tab').removeClass('active');

			$('#step-one').removeClass('d-none');
			$('#step-two').addClass('d-none');
		})

		function stepPassword() {

			if ($('#email').val() == "") {
				$('#email').addClass('is-invalid');
				$('#email').focus();
				$('#stepEmail-tab').addClass('active');
				$('#stepPassword-tab').removeClass('active');
				return false;
			}

			// if ($('#step-one').hasClass('d-none')) {
			// 	$('#stepEmail-tab').removeClass('active');
			// 	$('#stepPassword-tab').addClass('active');

			// 	$('#step-one').addClass('d-none');
			// 	$('#step-two').removeClass('d-none');
			// }
			
			$('#email').removeClass('is-invalid');
			$('#stepEmail-tab').removeClass('active');
			$('#stepPassword-tab').addClass('active');

			$('#step-one').addClass('d-none');
			$('#step-two').removeClass('d-none');
		}

		$('#submit-button').on('click', function() {

			if ($('#password').val() == "") {
				$('#password').addClass('is-invalid');
				$('#password').focus();
				return false;
			}

			$('#submit-button').html('Please wait...');
			$('#submit-button').attr('disabled', 'disabled');
			setTimeout(function () {
				$('#loginForm').submit();
			}, 2000)
		});
		
	</script>
