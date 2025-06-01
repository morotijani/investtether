<?php
    require ("../system/DatabaseConnector.php");
    if (!user_is_logged_in()) {
        user_login_redirect();
    }
    $newFont = "yes";
    include ("../head.php");
    

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

                            <div class="row g-3 g-xl-6">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start gap-4">
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/<?= $coin_data['data'][0]['id']; ?>.png"; class="w-rem-6 h-rem-6 rounded-circle img-fluid w-rem-6 h-rem-6" alt="...">
                                                <div>
                                                    <div class="mb-2">
                                                        <span class="d-block text-xs text-muted text-opacity-75"><?= $coin_data['data'][0]['name']; ?> (<?= $coin_data['data'][0]['symbol']; ?>)</span> 
                                                        <span class="d-block fw-bold text-heading text-sm"><?= number_format($coin_data['data'][0]['quote']['USD']['price'], 2); ?> USD</span>
                                                    </div>
                                                    <div>
                                                        <span class="d-block text-xs text-muted text-opacity-75">Market cap</span> 
                                                        <span class="d-block fw-bold text-heading text-sm"><?= number_format($coin_data['data'][0]['quote']['USD']['market_cap'], 2); ?> USD</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start gap-4">
                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/<?= $coin_data['data'][1]['id']; ?>.png"; class="w-rem-6 h-rem-6 rounded-circle img-fluid w-rem-6 h-rem-6" alt="...">
                                                <div>
                                                    <div class="mb-2">
                                                        <span class="d-block text-xs text-muted text-opacity-75"><?= $coin_data['data'][1]['name']; ?> (<?= $coin_data['data'][1]['symbol']; ?>)</span> 
                                                        <span class="d-block fw-bold text-heading text-sm"><?= number_format($coin_data['data'][1]['quote']['USD']['price'], 2); ?> USD</span>
                                                    </div>
                                                    <div>
                                                        <span class="d-block text-xs text-muted text-opacity-75">Market cap</span> 
                                                        <span class="d-block fw-bold text-heading text-sm"><?= number_format($coin_data['data'][1]['quote']['USD']['market_cap'], 2); ?> USD</span>
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

				<div class="mx-auto">
                <ul class="nav nav-segment d-flex justify-content-between">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= PROOT; ?>app">
                                <i class="bi-house nav-icon"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= PROOT; ?>app/">
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
                            <a class="nav-link" href="<?= PROOT; ?>app/settings">
                                <i class="bi-sliders nav-icon"></i> Settings
                            </a>
                        </li>
                    </ul>
					<div class="card card-lg zi-2">
						<div class="card-body">
                            
                            <!-- Features Step -->
                            <div class="overflow-hidden">
                                <div class="container content-space-b-1 content-space-b-md-3 mt-4">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8 order-md-2 mb-7 mb-md-0">
                                            <!-- Tab Content -->
                                            <div class="tab-content" id="step-TabFeaturesContent">
                                                <div class="tab-pane fade show active" id="stepFeaturesOne" role="tabpanel" aria-labelledby="stepFeaturesOne-tab">
                                            
                                                    <form class="vstack gap-6 border p-4" id="sendCryptoForm">
                                                        <ul class="step step-sm step-icon-sm step-centered" id="step-TabFeatures" role="tablist">
                                                            <li class="step-item" role="presentation">
                                                                <a class="step-content-wrapper active" href="javascript:;" id="stepSend-tab">
                                                                    <span class="step-icon step-icon-soft-secondary">1</span>
                                                                    <div class="step-content">
                                                                        <h6 class="step-title">Send</h6>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="step-item" role="presentation">
                                                                <a class="step-content-wrapper" href="javascript:;" id="stepSummary-tab">
                                                                    <span class="step-icon step-icon-soft-secondary">2</span>
                                                                    <div class="step-content">
                                                                        <h6 class="step-title">Summary</h6>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li class="step-item" role="presentation">
                                                                <a class="step-content-wrapper" href="javascript:;" id="stepConfirm-tab">
                                                                    <span class="step-icon step-icon-soft-secondary">2</span>
                                                                    <div class="step-content">
                                                                        <h6 class="step-title">Confirm</h6>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>

                                                        <div id="step-1">
                                                            <div class="vstack gap-1 mb-3">
                                                                <!-- <h4 class="fw-semibold">Send Crypto</h4>
                                                                <p class="text-muted">Send crypto to another wallet address.</p>
                                                            </div> -->

                                                                <div class="bg-light rounded-3 p-4">
                                                                    <div class="d-flex justify-content-between text-xs text-muted">
                                                                        <span class="fw-semibold">From</span> 
                                                                        <span>
                                                                            1
                                                                            <span id="preview-symbol">
                                                                                <?= $coin_data['data'][0]['symbol']; ?>
                                                                            </span>: 
                                                                            <span id="preview-amount">
                                                                                <?= number_format($coin_data['data'][0]['quote']['USD']['price'], 2); ?> USD
                                                                            </span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between gap-2 mt-4">
                                                                        <input type="number" min="1" id="send_amount" name="send_amount" class="form-control form-control-flush text-xl fw-bold flex-fill" placeholder="$0.00" oninput="validatePositiveNumber(this)" autocomplete="off" inputmode="numeric"> 
                                                                        <div class="dropdown" >
                                                                            <button class="btn btn-sm rounded-pill shadow-none flex-none d-flex align-items-center gap-2 p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <img src="https://s2.coinmarketcap.com/static/img/coins/64x64/<?= $coin_data['data'][0]['id']; ?>.png"; class="w-rem-6 h-rem-6 rounded-circle img-fluid" alt="..." id="preview-logo"> 
                                                                                <span id="preview-symbol-selected"><?= $coin_data['data'][0]['symbol']; ?></span> 
                                                                                <i class="bi bi-chevron-down text-xs me-1"></i>

                                                                                <input type="hidden" name="to_crypto_details_default" id="to_crypto_details_default" value="<?= $coin_data['data'][0]['id'] . '/' . $coin_data['data'][0]['symbol'] . '/' . $coin_data['data'][0]['name'] . '/' . number_format($coin_data['data'][0]['quote']['USD']['price'], 2); ?>">

                                                                            </button>
                                                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-sm" id="list-crypto">
                                                                                <?php 
                                                                                    if (is_array($coin_data)) {
                                                                                        if (isset($coin_data['data'])) {
                                                                                            foreach (array_slice($coin_data['data'], 0, 5) as $crypto) {
                                                                                                $icon = "https://s2.coinmarketcap.com/static/img/coins/64x64/{$crypto['id']}.png";
                                                                                ?>
                                                                                <li>
                                                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:;">
                                                                                        <img src="<?= $icon; ?>" class="w-rem-6 h-rem-6 rounded-circle img-fluid" alt="..."> 
                                                                                        <span><?= $crypto['symbol']; ?></span>
                                                                                        <input type="hidden" name="to_cypto_id" id="to_crypto_details" value="<?= $crypto['id'] . '/' .$crypto['symbol'] . '/' . $crypto['name'] . '/' . number_format($crypto['quote']['USD']['price'], 2); ?>">

                                                                                    </a>
                                                                                </li>
                                                                                <?php 
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                ?>
                                                                                <input type="hidden" name="to_cypto" id="to_cypto" value="">
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="position-relative text-center my-n4 overlap-10">
                                                                    <div class="icon icon-sm icon-shape bg-body shadow-soft-3 rounded-circle text-sm text-body-tertiary">
                                                                        <i class="bi bi-currency-bitcoin"></i>
                                                                    </div>
                                                                </div>

                                                                <div class="bg-light rounded-3 p-4">
                                                                    <div class="d-flex justify-content-between text-xs text-muted">
                                                                        <span class="fw-semibold">Amount in Crypto</span> 
                                                                        <span><span id="amount-in-crypto-crypto"></span>: <span id="amount-in-crypto-amount"></span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">To wallet address</label>
                                                                <div class="d-flex flex-wrap gap-1 gap-sm-2">
                                                                    <div class="w-sm-56 input-group input-group-sm input-group-inline">
                                                                        <input type="search" autocomplete="false" class="form-control fw-bolder" name="to_wallet_address" id="to_wallet_address" placeholder="1KFzzGtDdnq5h....nKzRbvf8WVxck"> 
                                                                        <span class="input-group-text" style="cursor: pointer;" onclick="pasteFromClipboard()"><i class="bi bi-clipboard2-check"></i>&nbsp; Paste</span>
                                                                    </div>
                                                                    <small class="form-text">As money transmitted to the wrong address may result in permanent loss, make sure the address is accurate.</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="note">Comment</label>
                                                                <textarea class="form-control form-control-xl fw-bolder" placeholder="Leave a comment here" style="overflow: hidden; resize: none;" id="note" name="note"></textarea>
                                                            </div>
                                                            <button type="button" id="next-1" class="btn btn-dark w-100" disabled>Next >></button>
                                                        </div>

                                                        <div id="step-2" class="d-none text-center">
                                                            <ul class="list-group" id="sendsummary"></ul>
                                                            <button type="button" class="btn btn-warning w-100 mt-4" id="next-2">Proceed >>></button>
                                                            <br><br>
                                                            <a href="javascript:;" class="text-dark" id="prev-1"><< Go Back</a>
                                                        </div>

                                                        <div id="step-3" class="d-none">
                                                            <div class="inputpin mb-3">
                                                                <div>
                                                                    <label class="form-label">Enter pin</label>
                                                                    <div class="d-flex justify-content-between p-4 bg-light rounded">
                                                                        <input type="password" class="form-control form-control-flush text-xl fw-bold w-rem-40 bg-transparent" placeholder="0000" name="pin" id="pin" autocomplete="off" inputmode="numeric" data-maxlength="4" oninput="this.value=this.value.slice(0,this.dataset.maxlength)" required>
                                                                        <button type="button" class="btn btn-sm btn-light rounded-pill shadow-none flex-none d-flex align-items-center gap-2 p-2 border">
                                                                            <img src="<?= PROOT; ?>assets/media/pin.jpg" class="w-rem-6 h-rem-6 rounded-circle" alt="..."> <span>PIN</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <a href="javascript:;" class="text-dark" id="prev-2"><<< Go Back</a>
                                                            </div>
                                                            <button type="button" class="btn btn-success w-100" id="send-crypto-button" name="send-crypto-button">Send</button>
                                                        </div>
                                                        <div id="loader-tag" class="d-none text-center">
                                                            <video muted autoplay width="auto" height="200" loop>
                                                                <source src="<?= PROOT; ?>assets/media/coin-loader.mp4" type="video/mp4">
                                                                <source src="<?= PROOT; ?>assets/media/coin-loader.ogg" type="video/ogg">
                                                            </video>
                                                        </div>
                                                    </form>
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
    <script src="<?= PROOT; ?>assets/js/wallet-address-validator.min.js"></script>

	<script>
        // conver from fiat to crypto
        async function convertToCrypto(amountUSD, cryptoSymbol, fiatSymbol = "USD") {
            
            try {
                $('#amount-in-crypto-amount').text('Converting ...');
                // **NEW:** Make the request to your PHP endpoint
                let response = await fetch('parsers/convert-to-crypto.php?amount=' + amountUSD + '&symbol=' + cryptoSymbol + '&convert=' + fiatSymbol, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                });
                let data = await response.json();

                if (data.status.error_code == 0) {
                    let cryptoAmount = data.data[cryptoSymbol].quote[fiatSymbol].price;
                    cryptoAmount = amountUSD / cryptoAmount
                    cryptoAmount = cryptoAmount.toFixed(8);
                    return cryptoAmount;

                } else {
                    $('#amount-in-crypto-amount').text(data.status.error_message);
                    console.error("Failed to fetch:", data.status.error_message);
                }

            } catch (error) {
                $('#amount-in-crypto-amount').text("Failed to convert, please refresh page and try again.");
                console.error("Failed to fetch:", error);
            }
        }

		$(document).ready(function() {

            var crypto_id
            var crypto_symbol
            var crypto_name
            var crypto_amount
            var crypto_logo

            $('#send_amount').on('change', function(e) {
                e.preventDefault();

                var send_amount = $('#send_amount').val()
                var coin = $("#to_crypto_details_default").val();
                var crypto = $("#to_cypto").val(coin);

                coin = coin.split("/");
                crypto_symbol = coin[1];
                crypto_name = coin[2];
                convertToCrypto(send_amount, crypto_symbol, "USD").then(conversionValue => {
                    if (
                        conversionValue == NaN || 
                        conversionValue == undefined || 
                        conversionValue == null || 
                        conversionValue <= 0 || 
                        conversionValue == Infinity
                    ) {
                        $('#amount-in-crypto-amount').text('Failed to convert, please refresh page and try again.');
                        $('#next-1').attr('disabled', true);
                    } else {
                        $('#amount-in-crypto-amount').text(conversionValue + ' ' + crypto_symbol);
                        $('#next-1').attr('disabled', false);
                    }
                });
                $('#amount-in-crypto-crypto').text(crypto_name);
            })


            // get selected crypto
            $("#list-crypto").on("click", "li", (function() {
                var send_amount = $('#send_amount').val()
                var coin = $(this).find("#to_crypto_details").val();
                $('#to_crypto_details_default').val(coin)
                var crypto = $("#to_cypto").val(coin);
                coin = coin.split("/");

                crypto_id = coin[0];
                crypto_symbol = coin[1];
                crypto_name = coin[2]
                crypto_amount = coin[3];
                crypto_logo = 'https://s2.coinmarketcap.com/static/img/coins/64x64/' + coin[0] + '.png';

                $('#preview-symbol').text(crypto_symbol);
                $('#preview-symbol-selected').text(crypto_symbol)
                $('#preview-amount').text(crypto_amount);
                $('#preview-logo').attr('src', crypto_logo);

                convertToCrypto(send_amount, crypto_symbol, "USD").then(conversionValue => {
                    if (
                        conversionValue == NaN || 
                        conversionValue == undefined || 
                        conversionValue == null || 
                        conversionValue <= 0 || 
                        conversionValue == Infinity
                    ) {
                        $('#amount-in-crypto-amount').text('Failed to convert, please refresh page and try again.');
                        $('#next-1').attr('disabled', true);
                    } else {
                        $('#amount-in-crypto-amount').text(conversionValue + ' ' + crypto_symbol);
                        $('#next-1').attr('disabled', false);
                    }
                });
                $('#amount-in-crypto-crypto').text(crypto_name);
            }));


            /**
             * SEND FUNDS
             */
            $('#next-1').click(function(e) {
                e.preventDefault();
                var send_amount = $('#send_amount').val()
                if (crypto_symbol == 'USDT') {
                    crypto_name = 'Tether';
                }

                var to_wallet_address = $('#to_wallet_address').val();

                if (send_amount <= 0) {
                    alert('* Invalid amount.');
                    $("#send_amount").focus()
                    return false;
                }

                if (to_wallet_address == '') {
                    alert('* To address needed.');
                    $("#to_wallet_address").focus()
                    return false;
                } else {
                    // WAValidator is exposed as a global (window.WAValidator)
                    var valid = WAValidator.validate(to_wallet_address, crypto_name.toLowerCase());
                    if (!valid) {
                        alert('Address INVALID');
                        $("#to_wallet_address").focus()
                        return false;
                    }
                }

                $('#sendsummary').html(
				`
					<li class="list-group-item out">
				  		<small class="text-muted">You’re sending,</small>
				  		<p id="send-crypto">` + crypto_name + `: ${$('#amount-in-crypto-amount').text()}</p>
				  	</li>
				  	<li class="list-group-item out">
				  		<small class="text-muted">Amount</small>
				  		<p id="send-amount">` + Number($("#send_amount").val()).toFixed(2) + ` USD</p>
				  	</li>
				  	<li class="list-group-item out">
				  		<small class="text-muted">Fees In ` + crypto_symbol + `</small>
				  		<p id="send-fees">0.00003005 + 2% ` + crypto_symbol + `</p>
				  	</li>
				  	<li class="list-group-item out">
				  		<small class="text-muted">To</small>
				  		<p id="send-receiving-address">` + to_wallet_address + `</p>
				  	</li>
				  	<li class="list-group-item out">
				  		<small class="text-muted">Note</small>
				  		<p id="send-note">` + $("#note").val() + `</p>
				  	</li>
				`);

                $('#step-1').addClass('d-none');
                $('#step-2').removeClass('d-none');

                $('#stepSend-tab').removeClass('active');
                $('#stepSummary-tab').addClass('active');
            });

            $('#next-2').click(function(e) {
                e.preventDefault();

                $('#step-2').addClass('d-none');
                $('#step-3').removeClass('d-none');

                $('#stepSummary-tab').removeClass('active');
                $('#stepConfirm-tab').addClass('active');
            })

            $('#send-crypto-button').click(function(e) {
                e.preventDefault()
                var pin = $('#pin').val();
                var balance = '<?= $user_data['user_balance']; ?>'
                var user_pin = '<?= $user_data['user_pin']; ?>'

                if (pin == '') {
                    alert('Enter pin to proceed');
                    $('#pin').focus();
                    return false;
                }

                if (pin.length < 4) {
                    alert('Pin must be 4 digits');
                    $('#pin').focus();
                    return false;
                }

                if (pin.length > 4) {
                    alert('Pin must be 4 digits');
                    $('#pin').focus();
                    return false;
                }

                if (+balance < +$('#send_amount').val()) {
                    alert('Insufficient balance');
                    $('#send_amount').focus();
                    $('#step-1').removeClass('d-none');
                    $('#step-2').addClass('d-none');
                    $('#step-3').addClass('d-none');

                    $('#stepConfirm-tab').removeClass('active');
                    $('#stepSend-tab').addClass('active');

                    return false;
                }

                $('#step-3').addClass('d-none');
                $('#loader-tag').removeClass('d-none');
                setTimeout(() => {
                    $('#loader-tag').addClass('d-none');
                    // alert('Transaction successful');
                    $('#sendCryptoForm').attr('method', 'POST');
                    $('#sendCryptoForm').attr('action', '<?= PROOT; ?>app/parsers/send-crypto');
                    $('#sendCryptoForm').submit();
                    // location.reload();
                }, 5000);
            })

            $('#prev-1').click(function(e) {
                e.preventDefault();

                $('#step-1').removeClass('d-none');
                $('#step-2').addClass('d-none');

                $('#stepSend-tab').addClass('active');
                $('#stepSummary-tab').removeClass('active');
            })

            $('#prev-2').click(function(e) {
                e.preventDefault();

                $('#step-2').removeClass('d-none');
                $('#step-3').addClass('d-none');

                $('#stepConfirm-tab').removeClass('active');
                $('#stepSummary-tab').addClass('active');
            })
		})

        
	$(document).ready(function() {

    })


	</script>
