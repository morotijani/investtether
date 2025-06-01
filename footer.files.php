	<!-- ReceiveModal -->
	<div class="modal fade" id="receiveModal" tabindex="-1" aria-labelledby="receiveModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  		<div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content" style="border-top: 5px solid green">
		      	<div class="modal-header">
		        	<h5 class="modal-title text-inherit" id="receiveModalLabel">Receive Funds</h5>
		        	<button type="button" class="btn-close receive-close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
		      	</div>
		      	<div class="modal-body">
                    <p class="card-text text-body" id="receive-fund-info"></p>
                    <form id="receivefundForm">
                        <div class="row" data-kt-buttons="true" id="receive-step-1">
                            <?php 
                                if (is_array($coin_data)) {
                                    if (isset($coin_data['data'])) {
                                        $i = 1;
                                        foreach (array_slice($coin_data['data'], 0, 5) as $crypto) {
                                            $icon = "https://s2.coinmarketcap.com/static/img/coins/64x64/{$crypto['id']}.png";

                            ?>
                                            <input type="radio" class="btn-check" name="receive_crypto_type" id="receive_crypto_type<?= $i; ?>" autocomplete="off" value="<?= $crypto['name']; ?>">
                                            <label class="btn" for="receive_crypto_type<?= $i; ?>">                                                                                        
                                                <img src="<?= $icon; ?>" class="w-rem-6 h-rem-6 rounded-circle img-fluid" alt="..."> <?= $crypto['name'] . ' (' .$crypto['symbol'] . ')'; ?> 
                                            </label>
                            
                            <?php 
                                            $i++;
                                        }
                                    }
                                }
                            ?>
                            <button type="button" class="btn btn-success mt-2" id="receive-view-btn">View</button>
                        </div>
                        <div id="receive-step-2" class="d-none text-center">
                            <div class="w-sm-56 input-group input-group-sm input-group-inline">
                                <input type="search" class="form-control fw-bolder" name="recieve_wallet_address" id="recieve_wallet_address" value="" placeholder="Receive wallet address" readonly> 
                                <span class="input-group-text" style="cursor: pointer;" onclick="copyToClipboard(document.getElementById('recieve_wallet_address').value)"><i class="bi bi-clipboard2"></i>&nbsp; Copy</span>
                            </div>
                            <div class="text-center my-4">
                                or
                            </div>
                            <img src="" style="width: auto; height: 250px" class="qr-code img-thumbnail img-fluid" />
                            <br>
                            <small>Receive by scanning this QR code.</small>
                            <p id="share-moreinfo"></p>
                            <br>
                            <a href="javascript:;" id="back-to-receive-step-1"><< Back</a>
                        </div>
                    </form>
		      	</div>
		    </div>
		</div>
    </div>

    <!-- Go To -->
	<div class="btn-scroll-top">
   <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
      <path d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
   </svg>
</div>

	 <style>
        .cookie-wrapper {
            position: fixed; 
            bottom: 50px; 
            right: -370px; 
            max-width: 345px; 
            width: 100%;
            transition: right 0.3s ease;
            z-index: 2;
        }

        .cookie-wrapper.show { 
            right: 20px;
        }
    </style>
    <div class="cookie-wrapper card w-75 bg-soft-warning">
        <div class="card-body">
            <h5 class="card-title">Cookies Consent</h5>
            <p class="card-text">This website uses cookies to ensure you get the best experience on our website. <a class="" href="#">Learn more</a>
			</p>
            <button class="btn btn-sm btn-outline-dark cookie-button" id="acceptBtn">Accept</button>
        </div>
    </div>

	<!-- TOAST MESSAGES -->
    <div class="toast-container translate-middle-x position-fixed start-50 bottom-0 end-0 p-3"> 
        <div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body"></div>
        </div>
    </div>

	<?= $flash_user; ?>

	<script src="<?= PROOT; ?>assets/js/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


	<script src="<?= PROOT; ?>assets/js/vendor.min.js"></script>
	<script src="<?= PROOT; ?>assets/js/theme.min.js"></script>


	
	<!-- Libs JS -->
	<script src="<?= PROOT; ?>assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= PROOT; ?>assets/js/simplebar.min.js"></script>
	<script src="<?= PROOT; ?>assets/js/headhesive.min.js"></script>

	<!-- Theme JS -->
	<script src="<?= PROOT; ?>assets/js/theme.min.js"></script>


   <!--Swiper JS -->
   <script src="<?= PROOT; ?>assets/js/swiper-bundle.min.js"></script>
   <script src="<?= PROOT; ?>assets/js/swiper.js"></script>
   <script src="<?= PROOT; ?>assets/js/scrollCue.min.js"></script>
   <script src="<?= PROOT; ?>assets/js/scrollcue.js"></script>



	<!-- JS Plugins Init. -->
	<script>
		// Fade out messages 
		$("#temporary").fadeOut(5000);

        let isHidden = true; // Track balance visibility

        function toggleBalance() {
            let balance = document.getElementById("balance");
            let button = $(".view-hide-balance");

            if (isHidden) {
                balance.classList.remove("blurred"); // Show balance
                button.removeClass("bi-eye");
                button.addClass("bi-eye-slash");
            } else {
                balance.classList.add("blurred"); // Hide balance
                button.removeClass("bi-eye-slash");
                button.addClass("bi-eye");
            }

            isHidden = !isHidden; // Toggle state
        }
		
        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                $('.toast').addClass('alert-info');
				$('.toast-body').html("Copied to clipboard:" + text);
				$('.toast').toast('show');
                console.log("Copied to clipboard:", text);
            }).catch(err => {
                console.error("Failed to copy:", err);
            });
        }

        // Paste from clipboard
        async function pasteFromClipboard() {
            try {
                let text = await navigator.clipboard.readText();
                alert("Pasting: " + text);
                $('#to_wallet_address').val(text);
            } catch (err) {
                console.error("Failed to paste:", err);
            }
        }

        //
        function validatePositiveNumber(input) {
            if (input.value <= 0) {
                input.value = 1;
            }
        }

		// validate email
		function isEmail(email) { 
            return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
        }

		(function() {

			// INITIALIZATION OF SHOW ANIMATIONS
			// =======================================================
			// new HSShowAnimation('.js-animation-link')


			// INITIALIZATION OF BOOTSTRAP VALIDATION
			// =======================================================
			HSBsValidation.init('.js-validate', {
			onSubmit: data => {
				data.event.preventDefault()
				alert('Submited')
			}
			})

			// INITIALIZATION OF TOGGLE PASSWORD
			// =======================================================
			new HSTogglePassword('.js-toggle-password')


			// INITIALIZATION OF GO TO
			// =======================================================
			new HSGoTo('.js-go-to')

			// INITIALIZATION OF SWIPER
    		// =======================================================
			var equalHeight = new Swiper('.js-swiper-equal-height', { 
				autoplay: {
					delay: 2000,
					disableOnInteraction: false,
				},
				pagination: {
					el: '.js-swiper-equal-height-pagination',
					clickable: true,
				},
				breakpoints: {
					320: {
						slidesPerView: 1,
						spaceBetween: 15,
					},
					580: {
						slidesPerView: 2,
						spaceBetween: 15,
					},
					768: {
						slidesPerView: 3,
						spaceBetween: 15,
					},
					1024: {
						slidesPerView: 4,
						spaceBetween: 15,
					},
				}
			});

		})()

		$(document).ready(function() {
			// display qr code for receive fund
			$('#receive-view-btn').click(function(e) {
				e.preventDefault();
				var walletAddress = '';
				var walletName = '';
				var qrcodeUrl = '';

				if ($("input[name=receive_crypto_type").is(':checked') != true) {
					$('.toast').addClass('alert-danger');
					$('.toast-body').html("Select a crypto to receive funds!");
					$('.toast').toast('show');
					return false;
				}

				for (var i = 1; i <= 5; i++) {
					if ($('#receive_crypto_type' + i).is(':checked') == true) {
						walletName = $('#receive_crypto_type' + i).val();
						if (walletName == 'Bitcoin') {
							walletAddress = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71';
						} else if (walletName == 'Ethereum') {
							walletAddress = '0x1D1479C185d32EB90533a08b36B3CFa5F84A0E6B';
						} else if (walletName == 'Tether USDt') {
							walletAddress = '0x9702230a8ea53601f5cd2dc00fdbc13d4df4a8c7';
						} else if (walletName == 'BNB') {
							walletAddress = '0x10d543e2e0355e36c5cab769df8d2d60abb77a73';
						} else if (walletName == 'XRP') {
							walletAddress = 'rf1BiGeXwwQoi8Z2ueFYTEXSwuJYfV2Jpn';
						}
						
						$('#recieve_wallet_address').val(walletAddress);
						qrcodeUrl = 'https://qrcode.tec-it.com/API/QRCode?data=' + walletAddress + '&color=%2312642a&backcolor=%23ffffff&istransparent=True';
						$('#receive-fund-info').html('Send ' + walletName + ' to the address below');
						$('.qr-code').attr('src', qrcodeUrl);
						$('#receiveModalLabel').html('Receive ' + walletName);
						$('#share-moreinfo').html('Share your ' + walletName + ' address to receive funds.');

						$('#receive-step-1').addClass('d-none');
						$('#receive-step-2').removeClass('d-none');
						break;
					} else {
						continue;
					}
				}
			})

			$('#back-to-receive-step-1').click(function(e) {
				e.preventDefault();
				
				$('#receive-step-1').removeClass('d-none');
				$('#receive-step-2').addClass('d-none');
			})
		
			$('.receive-close-btn').click(function(e) {
				$('.qr-code').attr('src', '');
				$('#receiveModalLabel').html('Receive Funds');
				$('#receive-fund-info').html('');
				$('#receivefundForm')[0].reset();
				$('#receive-step-2').addClass('d-none');
				$('#receive-step-1').removeClass('d-none');	
			})
		})

		// setting cookie 
		const cookieBox = document.querySelector('.cookie-wrapper'),
			buttons = document.getElementsByTagName('button');

		const executeCodes = () => {
			if (document.cookie.includes("xpto")) return;
			
				cookieBox.classList.add("show");

				Array.from(buttons).forEach((button) => {
					button.addEventListener("click", () => {
						cookieBox.classList.remove("show");

						// check if accept button was cliked to set the cookie
						if (button.id == "acceptBtn") {
							// set cookie for 1 month
							document.cookie = "xptoCookieFrom= xpto; max-age=" + 60 * 60 *24 * 30;
						}
					})
				})
			}

        // executeCodes function will be called on webpage load
        window.addEventListener("load", executeCodes);
    </script>
</body>
</html>
