<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<meta name="webcrawlers" content="all">
	<meta name="rating" content="general">
	<meta name="spiders" content="all">
	<meta name="revisit-after" content="7">
	<meta name="googlebot" content="noodp">
	<!-- meta open graph facebook -->
	<?php $meta = get_meta() ?>
	<meta property="og:site_name" content="<?php echo $this->config->config['blogname'] ?>" />
	<meta property="og:url" content="<?php echo $meta['u']; ?>" />
	<meta property="og:title" content="<?php echo $this->config->config['blogname'] ?>" />
	<meta property="og:description" content="<?php echo $meta['d']; ?>" />
	<meta name="description" content="<?php echo $meta['d']; ?>" />
	<meta name="keywords" content="<?php echo $meta['k']; ?>" />
	<meta property="og:image" content="<?php echo $meta['i']; ?>" />

	<link rel="shortcut icon" href="<?php echo $this->config->config['blogimgheader'] ?>" type="image/x-icon" />
	<title><?php echo $this->config->config['blogname'] ?></title>

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700&display=swap">

	<!-- CSS Global Compulsory (Do not remove)-->
	<link rel="stylesheet" href="<?= base_url('themes/umk/assets/css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('themes/umk/assets/css/animations.css') ?>">
	<link rel="stylesheet" href="<?= base_url('themes/umk/assets/css/fonts.css') ?>">
	<link rel="stylesheet" href="<?= base_url('themes/umk/assets/css/main.css') ?>" class="color-switcher-link">
	<link rel="stylesheet" href="<?= base_url('themes/umk/assets/css/shop.css') ?>">
</head>


<body style="<?php background(); ?>">
	<!-- <div class="body-background"></div>
		<div id="google_translate_element" style="position:fixed;top:10px;right:0px;z-index:99999"></div>
		-->


	<!-- template sections -->
	<div class="preloader">
		<div class="preloader_image"></div>
	</div>

	<!-- search modal -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal" id="search_modal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">
				<i class="rt-icon2-cross2"></i>
			</span>
		</button>
		<div class="widget widget_search">
			<form method="get" class="searchform search-form form-inline" action="./">
				<div class="form-group bottommargin_0">
					<input type="text" value="" name="search" class="form-control" placeholder="Search keyword" id="modal-search-input">
				</div>
				<button type="submit" class="theme_button">Search</button>
			</form>
		</div>
	</div>

	<!-- Unyson messages modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="messages_modal">
		<div class="fw-messages-wrap ls with_padding">
			<!-- Uncomment this UL with LI to show messages in modal popup to your user: -->
			<!--
		<ul class="list-unstyled">
			<li>Message To User</li>
		</ul>
		-->

		</div>
	</div>
	<!-- eof .modal -->


	<!-- template sections -->

	<section class="page_topline ls ms table_section visible-xs">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">

					<ul class="inline-list menu darklinks">
						<li class="search">
							<a href="#" class="search_modal_button header-button">
								<i class="fa fa-search" aria-hidden="true"></i>
							</a>
						</li>
					</ul>

				</div>
			</div>
		</div>
	</section>
	<!-- template header -->

	<header class="page_header header_white toggler_xs_right">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12 display_table">
					<div class="header_left_logo display_table_cell">
						<a href="./" class="logo top_logo">
							<img src="<?= base_url('themes/umk/assets/images/logo.jpeg') ?>" alt="" width="350" height="350">
						</a>
					</div>

					<div class="header_mainmenu display_table_cell text-center">
						<!-- main nav start -->
						<nav class="mainmenu_wrapper">
							<ul class="mainmenu nav sf-menu">

								<li class="<?php if (isset($is_home)) {
												echo 'nav-item dropdown active';
											} ?>">
									<a class="nav-link" href="<?php echo site_url(); ?>">Beranda</a>
									<?php $menu = [
										'menu' => get_menu()
									];
									foreach ($menu as $m) {
										"<li class='dropdown nav-item'";
										echo $m;
										"</li>";
									}
									?>
								</li>
								<!-- eof pages -->

								<!-- courses -->

								<!-- eof contacts -->
							</ul>
						</nav>
						<!-- eof main nav -->
						<!-- header toggler -->
						<span class="toggle_menu">
							<span></span>
						</span>
					</div>

					<div class="header_right_buttons display_table_cell text-right hidden-xs ls">
						<ul class="inline-list menu darklinks">
							<li>
								<!-- <div class="dropdown login-dropdown">
									<a href="#" id="login" data-target="#" data-toggle="dropdown" class="small-text medium">Login</a>
									<div class="dropdown-menu" aria-labelledby="login">

										<form>

											<div class="form-group has-placeholder">
												<label for="login-email">Email address</label>
												<input type="email" class="form-control" id="login-email" placeholder="Email Address">
											</div>


											<div class="form-group has-placeholder">
												<label for="login-password">Password</label>
												<input type="password" class="form-control" id="login-password" placeholder="Password">
											</div>

											<div class="content-justify divider_20">
												<div class="checkbox margin_0">
													<input type="checkbox" id="remember_me_checkbox">
													<label for="remember_me_checkbox" class="grey">Rememrber Me
													</label>
												</div>

												<a href="#" aria-expanded="false">
													Lost password?
												</a>
											</div>


											<button type="submit" class="theme_button block_button color1">Log In</button>
										</form>

										<p class="topmargin_10 text-center grey highlightlinks">
											Not a member yet? <a href="shop-register.html">Register now</a>
										</p>

									</div>
								</div> -->
							</li>
							<!-- <li>
								<a href="#" class="small-text medium">Sign up</a>
							</li> -->
							<li>
								<!-- <div class="dropdown cart-dropdown">
									<a href="#" id="cart" data-target="#" data-toggle="dropdown" title="View your shopping cart" class="cart-contents small-text header-button">
										<i class="fa fa-shopping-basket" aria-hidden="true"></i>
										<span class="count header-dropdown-number">2</span>
									</a>
									<div class="dropdown-menu widget_shopping_cart" aria-labelledby="cart">


										<div class="widget_shopping_cart_content">

											<ul class="cart_list product_list_widget ">
												<li class="media">
													<div class="media-left media-middle">
														<a href="shop-product-right.html">
															<img src="images/shop/01.png" class="muted_background" alt="">
														</a>
													</div>

													<div class="media-body">
														<h4>
															<a href="shop-product-right.html">Geology Fact Book</a>
														</h4>
														<div class="star-rating" title="Rated 4.0 out of 5">
															<span style="width:80%">
																<strong class="rating">4.0</strong> out of 5
															</span>
														</div>
														<span class="quantity">
															<span>1 ×</span>
															<span class="amount">$56.69</span>
														</span>
														<a href="#" class="remove" title="Remove this item"></a>
													</div>


												</li>
												<li class="media">
													<div class="media-left media-middle">
														<a href="shop-product-right.html">
															<img src="images/shop/02.png" class="muted_background" alt="">
														</a>
													</div>

													<div class="media-body">
														<h4>
															<a href="shop-product-right.html">Topographic Maps</a>
														</h4>
														<div class="star-rating" title="Rated 4.0 out of 5">
															<span style="width:60%">
																<strong class="rating">3.0</strong> out of 5
															</span>
														</div>
														<span class="quantity">
															<span>1 ×</span>
															<span class="amount">$13.25</span>
														</span>
														<a href="#" class="remove" title="Remove this item"></a>
													</div>


												</li>
											</ul>

											<p class="total content-justify topmargin_10 bottommargin_30">
												<span>Total:</span>
												<span class="amount oswald">$69.94</span>

											</p>

											<p class="buttons content-justify">
												<a href="shop-cart-right.html" class="theme_button color1 inverse">View cart</a>
												<a href="shop-checkout-right.html" class="theme_button color1">Checkout</a>
											</p>

										</div>

									</div>
								</div> -->
							</li>
							<li class="search">
								<a href="#" class="search_modal_button header-button">
									<i class="fa fa-search" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
</body>
<!-- PART:: END HEADER -->