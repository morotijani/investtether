<?php
    require ("system/DatabaseConnector.php");
    $newFont = "";
    include ("head.php");
    include ("nav.php");

	//
	if (isset($_POST['submitindex'])) {
		redirect(PROOT . 'auth/login');
	}

?>
    <!--====================== Intro Start ======================-->
    <section class="border-bottom section-padding">
      	<div class="container">
        	<div class="row justify-content-between align-items-center">
          		<div class="col-12 col-lg-6 mb-5 mb-lg-0">
					<h1 class="fw-bold mb-3 text-dark-400">Trade with <strong class="text-primary">InvestTether</strong>. <br> Buy and sell cryptocurrency</h1>
					<p class="mb-4 h4">Fast and secure way to purchase or exchange 150+ cryptocurrencies</p>
					<div class="d-grid gap-2 d-sm-block intro-btn mb-4 mb-lg-0">
						<a class="btn btn-primary me-sm-4" href="<?= PROOT; ?>auth/login">Get Started</a>
						<button class="btn btn-outline btn-outline-primary text-primary" type="button">Browse Now</button>
					</div>
					<!-- intro-content end -->
				</div>
				<div class="col-12 col-lg-5 offset-lg-1">
					<div class="intro-form-exchange p-4 shadow-5 rounded bg-white">
						<form class="needs-validation" method="POST" novalidate>
							<div class="mb-4">
								<label class="me-sm-2">Send</label>
								<div class="invalid-feedback">This field is required.</div>
									<div class="input-group">
										<select name='currency' class="form-select" required>
											<option value="1" selected>Bitcoin</option>
											<option value="2">USDT</option>
										</select>
										<input type="text" name="usd_amount" class="form-control" placeholder="125.00 USD" required>
									</div>
							</div>
							<div class="mb-4">
								<label class="me-sm-2">Get</label>
								<div class="invalid-feedback">This field is required.</div>
									<div class="input-group mb-3">
										<select name='currency' class="form-select" required>
											<option value="3" selected>Bitcoin</option>
											<option value="4">USDT</option>
										</select>
										<input type="text" name="usd_amount" class="form-control" placeholder="125.00 USD" required>
									</div>
								<div class="d-flex justify-content-between mt-0 align-items-center">
									<p class=" mb-0">Monthly Limit</p>
									<span class="mb-0 text-dark-400 fs-6 fw-semi-bold">$49,750 remaining</span>
								</div>
							</div>
							<button type="submit" name="submitindex" class="btn btn-primary w-100 position-relative text-white mt-2"> Exchange Now 
								<span class="btn-icon position-absolute"><i class="la la-arrow-right"></i></span>
							</button>
						</form>
					</div>
					<!-- intro-form-exchange end -->
				</div>
			</div>
		</div>
	</section>
    <!--====================== Intro End ======================-->
	
	<!--====================== Market Start ======================-->
    <section class="section-padding">
      	<div class="container">
        	<div class="row justify-content-center">
				<div class="col-12 col-xl-8">
					<div class="section-heading text-center">
						<h2>The World's Leading Cryptocurrency Exchange</h2>
						<p class="text-gray"> Trade Bitcoin, ETH, and hundreds of other cryptocurrencies in minutes.</p>
						</div>
					</div>
				</div>
				<!-- section-heading end -->
				<div class="row">
					<div class="col-12">
						<div class="table-card border-0">
							<div class="card-body p-0">
								<table>
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Price</th>
											<th>Change</th>
											<th>Chart</th>
											<th>Trade</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										if (is_array($coin_data)) {
											if (isset($coin_data['data'])) {
												foreach (array_slice($coin_data['data'], 0, 10) as $crypto) {
													$icon = "https://s2.coinmarketcap.com/static/img/coins/64x64/{$crypto['id']}.png";
													echo '<tr>
														<th scope="row" data-label="Number"><span class="fw-bold">' . $crypto['cmc_rank'] . '</span></th>
														<th data-label="Name">
															<div class="d-flex align-items-center">
																<span class="icon d-flex align-items-center justify-content-center me-3">
																	<img src="' . $icon . '" alt="' . $crypto['name'] .'" class="img-fluid w-rem-6 h-rem-6">
																</span>
																<span>' . $crypto['name'] . '</span>
																<span class="fw-normal ms-3">' . $crypto['symbol'] . '</span>
															</div>
														</th>
														<th data-label="Price"><span>USD ' . number_format($crypto['quote']['USD']['price'], 2) . '</span></th>
														<th data-label="Change"><span class="' . ($crypto['quote']['USD']['percent_change_24h'] >= 0 ? 'text-success' : 'text-danger') . '">' . number_format($crypto['quote']['USD']['percent_change_24h'], 2) . '%</span></th>
														<th data-label="Chart"><span class="sparkline8"></span></th>
														<th data-label="Button"><a href="'.PROOT.'auth/login" class="btn btn-success">Buy</a></th>
													</tr>';
									
												}
											} else {
												echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
											}
										} else {
											echo "<tr><td colspan='6' class='text-center'>Error fetching data</td></tr>";
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </section>
    <!--====================== Market End ======================-->

    <!--====================== Get start Start ======================-->
    <section class="section-padding bg-light-300">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-heading text-center mb-5">
              <h2>Get started in a few minutes</h2>
            </div>
          </div>
        </div>
        <div class="row g-5">
          <div class="col-12 col-md-4">
            <div class="text-center">
              <span class="text-primary fa-3x"><i class="la la-user-plus"></i></span>
              <h3 class="h4 fw-semi-bold mt-3 text-dark-400">Create an account</h3>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="text-center">
              <span class="text-primary fa-3x"><i class="la la-bank"></i></span>
              <h3 class="h4 fw-semi-bold mt-3 text-dark-400">Link your bank account</h3>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="text-center">
              <span class="text-primary fa-3x"><i class="la la-exchange"></i></span>
              <h3 class="h4 fw-semi-bold mt-3 text-dark-400">Start buying & selling</h3>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--====================== Get start End ======================-->

    <!--====================== Portfolio Start ======================-->
    <section class="portfolio section-padding" data-scroll-index="2">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-lg-7">
            <div class="section-heading text-center">
              <h2>Create your cryptocurrency portfolio today</h2>
              <p class="text-gray"> InvestTether has a variety of features that make it the best place to start trading</p>
            </div>
          </div>
        </div>

        <div class="row align-items-center justify-content-between">
          <div class="col-12 col-lg-6 col-xl-7">
              <div class="row g-5 g-lg-4">
                <div class="col-12 col-xl-6">
                  <div class="d-flex">
                    <span class="port-icon shadow-6 text-primary d-flex align-items-center justify-content-center rounded-circle fs-2 me-4"><i class="la la-bar-chart"></i></span>
                    <div>
                      <h3 class="fw-semi-bold text-dark-400 fs-4 mb-2">Manage your portfolio</h3>
                      <p class="text-gray"> Buy and sell popular digital currencies, keep track of them in the one
                        place.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <div class="d-flex">
                    <span class="port-icon shadow-6 text-primary d-flex align-items-center justify-content-center rounded-circle fs-2 me-4"> <i class="la la-calendar-check-o"></i></span>
                    <div>
                      <h3 class="fw-semi-bold text-dark-400 fs-4 mb-2">Recurring buys</h3>
                      <p class="text-gray"> Invest in cryptocurrency slowly over time by scheduling buys daily,
                        weekly,
                        or monthly.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <div class="d-flex">
                    <span class="port-icon shadow-6 text-primary d-flex align-items-center justify-content-center rounded-circle fs-2 me-4"> <i class="la la-lock"></i></span>
                    <div>
                      <h3 class="fw-semi-bold text-dark-400 fs-4 mb-2">Vault protection</h3>
                      <p class="text-gray"> For added security, store your funds in a vault with time delayed
                        withdrawals.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-6">
                  <div class="d-flex">
                    <span class="port-icon shadow-6 text-primary d-flex align-items-center justify-content-center rounded-circle fs-2 me-4"> <i class="la la-mobile"></i></span>
                    <div>
                      <h3 class="fw-semi-bold text-dark-400 fs-4 mb-2">Mobile apps</h3>
                      <p class="text-gray"> Stay on top of the markets with the InvestTether app for <a href="#!" class="text-primary">Android</a> or <a href="#!" class="text-primary">iOS</a>.</p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="col-12 col-lg-6 col-xl-5 mt-5 mt-lg-0">
            <img src="<?= PROOT; ?>assets/media/bg-1.png" loading="lazy" alt="…" class="img-fluid rounded shadow-7">
          </div>
        </div>
      </div>
    </section>
    <!--====================== Portfolio End ======================-->

    <!--====================== Trade App Start ======================-->
    <section class="trade-app section-padding pt-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-lg-6">
            <div class="section-heading text-center">
              <h2>Trade. Anywhere</h2>
              <p> All of our products are ready to go, easy to use and offer great value to any kind of  business.</p>
            </div>
          </div>
        </div>
        <div class="row g-4 section-padding pt-0">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-3 p-4">
              <div class="card-body pt-3 px-3 p-0">
                <span class="text-primary mb-3 fa-3x"><i class="la la-mobile"></i></span>
                <h3 class="fw-semi-bold text-dark-400 card-title mb-3 fs-5">Mobile</h3>
                <p class=" mb-4">All the power of InvestTether's cryptocurrency exchange, in the palm of your hand. Download the InvestTether mobile crypto trading app today</p>
              </div>
              <div class="card-footer p-0 bg-transparent border-0">
                <a href="#!" class="d-flex align-items-center text-primary fw-semi-bold"> Know More <i class="la la-arrow-right ms-3"></i> </a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-3 p-4">
              <div class="card-body p-0">
                <span class="text-primary mb-3 fa-3x"><i class="la la-desktop"></i></span>
                <h3 class="fw-semi-bold text-dark-400 card-title mb-3 fs-5">Desktop</h3>
                <p class=" mb-4">Powerful crypto trading platform for those who mean business. The InvestTether crypto  trading experience, tailor-made for your Windows or MacOS device.</p>
              </div>
              <div class="card-footer p-0 bg-transparent border-0">
                <a href="#!" class="d-flex align-items-center text-primary fw-semi-bold"> Know More <i class="la la-arrow-right ms-3"></i> </a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-3 p-4">
              <div class="card-body p-0">
                <span class="text-primary mb-3 fa-3x"><i class="la la-connectdevelop"></i></span>
                <h3 class="fw-semi-bold text-dark-400 card-title mb-3 fs-5">API</h3>
                <p class=" mb-4">The InvestTether API is designed to provide an easy and efficient way to integrate your trading  application into our platform.</p>   
              </div>
              <div class="card-footer bg-transparent border-0">
                <a href="#!" class="d-flex align-items-center text-primary fw-semi-bold"> Know More <i class="la la-arrow-right ms-3"></i> </a>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="section-heading text-center">
              <h4 class="fs-4 fw-semi-bold text-dark-400">Trusted by Our <strong>Partners & Investors</strong></h4>
            </div>
            
            <div class="row justify-content-between">
              <div class="client-slide owl-carousel owl-theme">
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/Bitcoin.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/CoinEdition.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/TET.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/CT.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/TIA.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/Bitcoin.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/CoinEdition.svg" loading="lazy" alt="…"></a>
                </div>
                <div class="client-logo text-center">
                  <a href="#!"><img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/CryptoDaily.svg" loading="lazy" alt="…"></a>
                </div>
              </div>
              <!-- client-slide end -->
            </div>

          </div>
        </div>
      </div>
    </section>
    <!--====================== Trade App End ======================-->


    <!--====================== Promo Start ======================-->
    <section class="promo section-padding bg-white border-bottom">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-xl-8">
            <div class="section-heading text-center">
              <h2>The most trusted cryptocurrency platform</h2>
              <p class="text-gray">  Here are a few reasons why you should choose InvestTether</p>
            </div>
          </div>
        </div>
        <div class="row g-4 align-items-center">
          <div class="col-12 col-md-4">
            <div class="text-center">
              <div class="promo-content-img d-flex align-items-center justify-content-center p-3 mx-auto my-4">
                <img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/protect.svg" loading="lazy" alt="…">
              </div>
              <h3 class="text-dark-400 fs-4 fw-semi-bold mb-3">Secure storage </h3>
              <p class="text-gray"> We store the vast majority of the digital assets in secure offline storage.</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="text-center">
              <div class="promo-content-img d-flex align-items-center justify-content-center p-3 mx-auto my-4">
                <img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/cyber.svg" loading="lazy" alt="…">
              </div>
              <h3 class="text-dark-400 fs-4 fw-semi-bold mb-3">Protected by insurance</h3>
              <p class="text-gray"> Cryptocurrency stored on our servers is covered by our insurance policy.</p>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="text-center">
              <div class="promo-content-img d-flex align-items-center justify-content-center p-3 mx-auto my-4">
                <img class="img-fluid" src="<?= PROOT; ?>assets/media/svg/finance.svg" loading="lazy" alt="…">
              </div>
              <h3 class="text-dark-400 fs-4 fw-semi-bold mb-3">Industry best practices</h3>
              <p class="text-gray">InvestTether supports a variety of the most popular digital currencies.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--====================== Promo End ======================-->

    <!--====================== Cta Start ======================-->
    <section class="section-padding  bg-light border-bottom">
		<div class="container">
			<div class="row align-items-center justify-content-between">
				<div class="col-12 col-md-6 col-xl-7">
					<h2 class="fw-bold mb-4">The secure app to store crypto yourself</h2>
					<ul class="check-list">
						<li>All your digital assets in one place</li>
						<li>Use Decentralized Apps</li>
						<li>Pay friends, not addresses</li>
					</ul>
					<div class="mt-4 d-grid gap-2 d-sm-block">
						<a href="#!" class="btn btn-lg btn-primary me-sm-2 rounded-pill">
							<img src="<?= PROOT; ?>assets/media/svg/android.svg" loading="lazy" alt="…">
						</a>
						<a href="#!" class="btn btn-lg btn-primary rounded-pill">
							<img src="<?= PROOT; ?>assets/media/svg/apple.svg" loading="lazy" alt="…">
						</a>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-5">
					<div class="mt-5 mt-md-0">
						<img class="img-fluid" src="<?= PROOT; ?>assets/media/bg-2.png" loading="lazy" alt="…">
					</div>
				</div>
			</div>
		</div>
    </section>
    <!--====================== Cta End ======================-->

   
    <!--====================== Get touch Start ======================-->
    <section class="get-touch section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-6">
            <div class="section-heading text-center">
              <h2>Get in touch. Stay in touch.</h2>
            </div>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-12 col-md-6">
            <div class="card flex-row shadow-2 bg-white rounded border-0 p-4">
              <span class="text-primary me-3"><i class="fas fa-shield-alt fa-2x"></i></span>
              <div class="card-body p-0">
                <h3 class="h5 fw-semi-bold text-dark-400 fs-5 mb-2">24 / 7 Support</h3>
                <p class="text-gray"> Got a problem? Just get in touch. Our support team is available 24/7.</p>
              </div>
            </div>
            <!-- card end -->
          </div>
          <div class="col-12 col-md-6">
            <div class="card flex-row shadow-2 bg-white rounded border-0 p-4">
              <span class="text-primary me-3"><i class="fas fa-cubes fa-2x"></i></span>
              <div class="card-body p-0">
                <h3 class="h5 fw-semi-bold text-dark-400 fs-5 mb-2">InvestTether Blog</h3>
                <p class="text-gray"> News and updates from the world’s leading cryptocurrency exchange. </p>
              </div>
            </div>
            <!-- card end -->
          </div>
          <div class="col-12 col-md-6">
            <div class="card flex-row shadow-2 bg-white rounded border-0 p-4">
              <span class="text-primary me-3"><i class="fas fa-certificate fa-2x"></i></span>
              <div class="card-body p-0">
                <h3 class="h5 fw-semi-bold text-dark-400 fs-5 mb-2">Careers</h3>
                <p class="text-gray"> Help build the future of technology. Start your new career at InvestTether.</p>
              </div>
            </div>
            <!-- card end -->
          </div>
          <div class="col-12 col-md-6">
            <div class="card flex-row shadow-2 bg-white rounded border-0 p-4">
              <span class="text-primary me-3"><i class="far fa-life-ring fa-2x"></i></span>
              <div class="card-body p-0">
                <h3 class="h5 fw-semi-bold text-dark-400 fs-5 mb-2">Community</h3>
                <p class="text-gray"> InvestTether is global. Join the discussion in our worldwide communities.</p>
              </div>
            </div>
            <!-- card end -->
          </div>
        </div>
      </div>
    </section>
    <!--====================== Get touch End ======================-->


   

<?php
 
    include ("footer.php");
    include ("footer.files.php");

?>
